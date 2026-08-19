<?php

class Order {
    /**
     * Create an order from a cart-style item map:
     * [ productId => ['qty' => int, 'price' => float(unit)] ]
     */
    public static function createForItems(int $userId, array $items): int {
        $pdo = db();
        $pdo->beginTransaction();
        try {
            $total = 0.0;
            foreach ($items as $it) {
                $total += (float)$it['price'] * (int)$it['qty'];
            }
            $orderNumber = 'DM-' . date('Ymd') . '-' . strtoupper(substr(bin2hex(random_bytes(4)), 0, 6));

            $s = $pdo->prepare('INSERT INTO orders(order_number,user_id,total_amount,payment_status) VALUES(?,?,?,?)');
            $s->execute([$orderNumber, $userId, $total, 'pending']);
            $orderId = (int)$pdo->lastInsertId();

            $itemStmt = $pdo->prepare('INSERT INTO order_items(order_id,product_id,price) VALUES(?,?,?)');
            foreach ($items as $productId => $it) {
                // store line total (unit price * qty) to preserve schema (id, order_id, product_id, price)
                $lineTotal = (float)$it['price'] * (int)$it['qty'];
                $itemStmt->execute([$orderId, (int)$productId, $lineTotal]);
            }

            $pdo->commit();
            return $orderId;
        } catch (\Throwable $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    public static function find(int $id): ?array {
        $s = db()->prepare('SELECT * FROM orders WHERE id = ?');
        $s->execute([$id]);
        return $s->fetch() ?: null;
    }

    public static function forUser(int $userId): array {
        $s = db()->prepare('SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC');
        $s->execute([$userId]);
        return $s->fetchAll();
    }

    public static function items(int $orderId): array {
        $s = db()->prepare('SELECT oi.*, p.title, p.slug FROM order_items oi
                            JOIN products p ON p.id = oi.product_id WHERE oi.order_id = ?');
        $s->execute([$orderId]);
        return $s->fetchAll();
    }

    public static function allWithUser(): array {
        return db()->query('SELECT o.*, u.name AS user_name, u.email AS user_email
                            FROM orders o JOIN users u ON u.id = o.user_id
                            ORDER BY o.created_at DESC')->fetchAll();
    }

    public static function markPaid(int $id): void {
        $s = db()->prepare("UPDATE orders SET payment_status = 'paid' WHERE id = ?");
        $s->execute([$id]);
    }

    /** Digital products the user has purchased in a paid order. */
    public static function paidProductsForUser(int $userId): array {
        $s = db()->prepare('SELECT DISTINCT p.* FROM products p
                            JOIN order_items oi ON oi.product_id = p.id
                            JOIN orders o ON o.id = oi.order_id
                            WHERE o.user_id = ? AND o.payment_status = "paid"
                            ORDER BY p.title ASC');
        $s->execute([$userId]);
        return $s->fetchAll();
    }

    public static function userHasPaidProduct(int $userId, int $productId): bool {
        $s = db()->prepare('SELECT COUNT(*) FROM orders o
                            JOIN order_items oi ON oi.order_id = o.id
                            WHERE o.user_id = ? AND oi.product_id = ? AND o.payment_status = "paid"');
        $s->execute([$userId, $productId]);
        return (int)$s->fetchColumn() > 0;
    }

    public static function stats(): array {
        $pdo = db();
        return [
            'total_sales'  => (float)$pdo->query("SELECT COALESCE(SUM(total_amount),0) FROM orders WHERE payment_status='paid'")->fetchColumn(),
            'total_orders' => (int)$pdo->query('SELECT COUNT(*) FROM orders')->fetchColumn(),
            'total_products' => (int)$pdo->query('SELECT COUNT(*) FROM products')->fetchColumn(),
            'paid_orders'  => (int)$pdo->query("SELECT COUNT(*) FROM orders WHERE payment_status='paid'")->fetchColumn(),
        ];
    }
}
