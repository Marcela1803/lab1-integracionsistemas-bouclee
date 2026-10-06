<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controladores\PedidoController;
use App\Modelos\Pedido;

$controller = new PedidoController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accion'])) {
        if ($_POST['accion'] === 'crear') {
            // Se agregan contacto y fecha_entrega
            $nuevoPedido = new Pedido($_POST['cliente'], $_POST['contacto'], $_POST['tipo_postre'], $_POST['fecha_entrega']);
            $controller->crearPedido($nuevoPedido, $_POST['cliente'], $_POST['contacto'], $_POST['tipo_postre'], $_POST['fecha_entrega']);
        } elseif ($_POST['accion'] === 'eliminar') {
            $controller->eliminarPedido($_POST['id']);
        } elseif ($_POST['accion'] === 'actualizar') {
            $controller->actualizarEstado($_POST['id'], $_POST['estado']);
        }
        header("Location: index.php");
        exit;
    }
}

$pedidos = $controller->obtenerPedidos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tablero de Pedidos Bouclée - Lab 1</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; }
        .btn { padding: 5px 10px; cursor: pointer; }
    </style>
</head>
<body>
    <h1>Gestión de Pedidos Bouclée</h1>
    
    <form method="POST" style="margin-bottom: 20px; padding: 15px; border: 1px solid #ccc;">
        <h3>Nuevo Encargo</h3>
        <input type="hidden" name="accion" value="crear">
        <input type="text" name="cliente" placeholder="Nombre del cliente" required>
        <input type="text" name="contacto" placeholder="Teléfono o IG" required>
        <input type="text" name="tipo_postre" placeholder="Ej. Tiramisú, Alfajores" required>
        <input type="date" name="fecha_entrega" required>
        <button type="submit" class="btn">Agregar Pedido</button>
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Contacto</th>
            <th>Postre</th>
            <th>Entrega</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($pedidos as $p): ?>
        <tr>
            <td><?= $p['id'] ?></td>
            <td><?= $p['cliente'] ?></td>
            <td><?= $p['contacto'] ?></td>
            <td><?= $p['tipo_postre'] ?></td>
            <td><?= $p['fecha_entrega'] ?></td>
            <td>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="accion" value="actualizar">
                    <input type="hidden" name="id" value="<?= $p['id'] ?>">
                    <select name="estado" onchange="this.form.submit()">
                        <option value="Pendiente" <?= $p['estado'] == 'Pendiente' ? 'selected' : '' ?>>Pendiente</option>
                        <option value="En Preparación" <?= $p['estado'] == 'En Preparación' ? 'selected' : '' ?>>En Preparación</option>
                        <option value="Entregado" <?= $p['estado'] == 'Entregado' ? 'selected' : '' ?>>Entregado</option>
                    </select>
                </form>
            </td>
            <td>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="accion" value="eliminar">
                    <input type="hidden" name="id" value="<?= $p['id'] ?>">
                    <button type="submit" class="btn">Eliminar</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>