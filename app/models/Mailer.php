<?php
// app/models/Mailer.php
// Clase para envío de correos. Usa PHPMailer si está disponible, si no usa mail()

class Mailer {

    // ─── Configuración SMTP ───────────────────────────────────────
    // Cambia estos valores con tus datos reales de correo
    const SMTP_HOST    = 'smtp.gmail.com';       // o smtp.tudominio.com
    const SMTP_PORT    = 587;
    const SMTP_USER    = 'arevalochanico9@gmail.com'; // tu correo real
    const SMTP_PASS    = 'zgjk xrrx kvoh ayim';    // contraseña de aplicación
    const FROM_NAME    = 'Le Mascotte';
    const FROM_EMAIL   = 'noreply@lemascotte.com';
    const REPLY_TO     = 'info@lemascotte.com';

    /**
     * Enviar correo HTML
     * Retorna true si se envió, false si falló
     */
    public static function send(string $to, string $subject, string $htmlBody, string $toName = ''): bool {
        // ── Intentar con PHPMailer (si está instalado via composer) ──
        if (class_exists('PHPMailer\PHPMailer\PHPMailer')) {
            return self::sendPHPMailer($to, $toName, $subject, $htmlBody);
        }
        // ── Fallback: mail() nativo de PHP ────────────────────────
        return self::sendNative($to, $subject, $htmlBody);
    }

    private static function sendNative(string $to, string $subject, string $html): bool {
        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
        $headers .= "From: " . self::FROM_NAME . " <" . self::FROM_EMAIL . ">\r\n";
        $headers .= "Reply-To: " . self::REPLY_TO . "\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();
        return mail($to, $subject, $html, $headers);
    }

    private static function sendPHPMailer(string $to, string $toName, string $subject, string $html): bool {
        try {
            $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = self::SMTP_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = self::SMTP_USER;
            $mail->Password   = self::SMTP_PASS;
            $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = self::SMTP_PORT;
            $mail->CharSet    = 'UTF-8';
            $mail->setFrom(self::FROM_EMAIL, self::FROM_NAME);
            $mail->addAddress($to, $toName);
            $mail->addReplyTo(self::REPLY_TO);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $html;
            $mail->AltBody = strip_tags($html);
            return $mail->send();
        } catch (\Exception $e) {
            error_log("Mailer Error: " . $e->getMessage());
            return false;
        }
    }

    // ═══════════════════════════════════════════════════════════════
    // PLANTILLAS DE CORREO
    // ═══════════════════════════════════════════════════════════════

    /** Envuelve el contenido en la plantilla base */
    private static function template(string $content): string {
        return <<<HTML
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
  body{margin:0;padding:0;background:#f5f0ed;font-family:'Segoe UI',Arial,sans-serif;}
  .wrap{max-width:600px;margin:32px auto;background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,.08);}
  .header{background:#FF6B35;padding:28px 32px;text-align:center;}
  .header h1{margin:0;color:#fff;font-size:24px;font-weight:700;letter-spacing:-0.5px;}
  .header p{margin:4px 0 0;color:rgba(255,255,255,.85);font-size:13px;}
  .body{padding:32px;}
  .body h2{color:#1a1008;font-size:20px;margin:0 0 16px;}
  .body p{color:#5a4a40;font-size:15px;line-height:1.7;margin:0 0 12px;}
  .info-box{background:#fff8f5;border:1px solid #ffdcc9;border-radius:10px;padding:18px 20px;margin:20px 0;}
  .info-row{display:flex;justify-content:space-between;padding:6px 0;border-bottom:1px solid #f0e6e0;font-size:14px;}
  .info-row:last-child{border:none;}
  .info-row .label{color:#8c7068;font-weight:600;}
  .info-row .value{color:#1a1008;font-weight:700;text-align:right;}
  .badge{display:inline-block;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:700;}
  .badge-orange{background:#fff0e8;color:#cc4e1a;}
  .badge-green{background:#e8f8ee;color:#14854a;}
  .badge-blue{background:#e6f1fb;color:#185fa5;}
  table.items{width:100%;border-collapse:collapse;margin:16px 0;font-size:14px;}
  table.items th{background:#fff8f5;padding:8px 12px;text-align:left;color:#8c7068;font-weight:700;border-bottom:2px solid #ffdcc9;}
  table.items td{padding:10px 12px;border-bottom:1px solid #f5f0ed;color:#1a1008;}
  table.items tr:last-child td{border:none;}
  .total-row td{font-weight:700;color:#FF6B35!important;font-size:16px;}
  .btn{display:inline-block;background:#FF6B35;color:#fff;padding:14px 28px;border-radius:10px;text-decoration:none;font-weight:700;font-size:15px;margin:16px 0;}
  .tip-box{background:#fffbea;border-left:4px solid #f59e0b;border-radius:0 8px 8px 0;padding:12px 16px;margin:20px 0;font-size:13px;color:#92400e;}
  .footer{background:#f5f0ed;padding:20px 32px;text-align:center;}
  .footer p{margin:0;color:#8c7068;font-size:12px;line-height:1.8;}
  .footer a{color:#FF6B35;text-decoration:none;font-weight:600;}
</style>
</head>
<body>
<div class="wrap">
  <div class="header">
    <h1>🐾 Le Mascotte</h1>
    <p>Clínica Veterinaria & Tienda de Mascotas</p>
  </div>
  <div class="body">
    $content
  </div>
  <div class="footer">
    <p>Le Mascotte · San Salvador, El Salvador<br>
    📞 +503 2200-0000 · ✉ <a href="mailto:info@lemascotte.com">info@lemascotte.com</a><br>
    Emergencias 24/7<br>
    <a href="http://lemascotte.com">www.lemascotte.com</a></p>
  </div>
</div>
</body>
</html>
HTML;
    }

    // ─── CONFIRMACIÓN DE PEDIDO ───────────────────────────────────
    public static function confirmacionPedido(array $pedido): bool {
        if (empty($pedido['email_cliente'])) return false;

        $itemsHtml = '';
        foreach ($pedido['items'] as $item) {
            $sub = number_format($item['precio_unitario'] * $item['cantidad'], 2);
            $itemsHtml .= "<tr>
                <td>{$item['nombre_producto']}</td>
                <td style='text-align:center'>{$item['cantidad']}</td>
                <td style='text-align:right'>\${$item['precio_unitario']}</td>
                <td style='text-align:right'>\${$sub}</td>
            </tr>";
        }

        $estadoBadge = "<span class='badge badge-orange'>Pendiente de confirmación</span>";
        $subtotal    = number_format($pedido['subtotal'], 2);
        $impuesto    = number_format($pedido['impuesto'], 2);
        $total       = number_format($pedido['total'], 2);
        $fecha       = date('d/m/Y H:i', strtotime($pedido['created_at']));
        $direccion   = htmlspecialchars($pedido['direccion_entrega']);

        $content = <<<HTML
<h2>¡Gracias por tu compra, {$pedido['nombre_cliente']}! 🎉</h2>
<p>Hemos recibido tu pedido correctamente. Te contactaremos pronto para coordinar la entrega.</p>

<div class="info-box">
  <div class="info-row"><span class="label">Número de pedido</span><span class="value">#00{$pedido['id']}</span></div>
  <div class="info-row"><span class="label">Fecha</span><span class="value">{$fecha}</span></div>
  <div class="info-row"><span class="label">Estado</span><span class="value">{$estadoBadge}</span></div>
  <div class="info-row"><span class="label">Dirección de entrega</span><span class="value">{$direccion}</span></div>
  <div class="info-row"><span class="label">Teléfono</span><span class="value">{$pedido['telefono']}</span></div>
</div>

<h2 style="margin-top:24px">Detalle de productos</h2>
<table class="items">
  <thead><tr><th>Producto</th><th>Cant.</th><th>Precio</th><th>Subtotal</th></tr></thead>
  <tbody>{$itemsHtml}</tbody>
  <tfoot>
    <tr><td colspan="3" style="text-align:right;color:#8c7068;padding:8px 12px">Subtotal</td><td style="text-align:right;padding:8px 12px">\${$subtotal}</td></tr>
    <tr><td colspan="3" style="text-align:right;color:#8c7068;padding:8px 12px">IVA (13%)</td><td style="text-align:right;padding:8px 12px">\${$impuesto}</td></tr>
    <tr class="total-row"><td colspan="3" style="text-align:right;padding:10px 12px">TOTAL</td><td style="text-align:right;padding:10px 12px">\${$total}</td></tr>
  </tfoot>
</table>

<div class="tip-box">
  💡 <strong>¿Tu mascota también necesita atención veterinaria?</strong> Agenda una cita médica en nuestra clínica. Emergencias 24/7.
</div>

<p>¿Tienes alguna duda? Contáctanos al <strong>+503 2200-0000</strong> o responde este correo.</p>
HTML;

        return self::send(
            $pedido['email_cliente'],
            "✅ Pedido #00{$pedido['id']} confirmado — Le Mascotte",
            self::template($content),
            $pedido['nombre_cliente']
        );
    }

    // ─── NOTIF. INTERNA: NUEVO PEDIDO AL ADMIN ────────────────────
    public static function notificarAdminNuevoPedido(array $pedido): bool {
        $total    = number_format($pedido['total'], 2);
        $fecha    = date('d/m/Y H:i', strtotime($pedido['created_at']));
        $adminUrl = APP_URL . '/admin/pedidos/' . $pedido['id'];

        $itemsList = implode('<br>', array_map(
            fn($i) => "• {$i['nombre_producto']} x{$i['cantidad']} = \${$i['precio_unitario']}",
            $pedido['items']
        ));

        $content = <<<HTML
<h2>🛒 Nuevo pedido recibido</h2>
<p>Se ha registrado un nuevo pedido en la tienda.</p>

<div class="info-box">
  <div class="info-row"><span class="label">Pedido #</span><span class="value">00{$pedido['id']}</span></div>
  <div class="info-row"><span class="label">Cliente</span><span class="value">{$pedido['nombre_cliente']}</span></div>
  <div class="info-row"><span class="label">Email</span><span class="value">{$pedido['email_cliente']}</span></div>
  <div class="info-row"><span class="label">Teléfono</span><span class="value">{$pedido['telefono']}</span></div>
  <div class="info-row"><span class="label">Dirección de entrega</span><span class="value">{$pedido['direccion_entrega']}</span></div>
  <div class="info-row"><span class="label">Total</span><span class="value">\${$total}</span></div>
  <div class="info-row"><span class="label">Fecha</span><span class="value">{$fecha}</span></div>
</div>

<p><strong>Productos:</strong><br>{$itemsList}</p>

<a href="{$adminUrl}" class="btn">Ver pedido en el panel →</a>
HTML;

        return self::send(self::REPLY_TO, "🛒 Nuevo pedido #00{$pedido['id']} — Le Mascotte", self::template($content), 'Admin Le Mascotte');
    }

    // ─── CONFIRMACIÓN DE CITA ─────────────────────────────────────
    public static function confirmacionCita(array $cita): bool {
        if (empty($cita['email'])) return false;

        $fecha    = date('d/m/Y', strtotime($cita['fecha_preferida']));
        $hora     = substr($cita['hora_preferida'], 0, 5);
        $tipo     = ucfirst($cita['tipo_mascota']);
        $estado   = $cita['estado'] === 'confirmada'
                    ? "<span class='badge badge-green'>Confirmada ✓</span>"
                    : "<span class='badge badge-orange'>Recibida – en revisión</span>";

        $content = <<<HTML
<h2>Cita registrada para {$cita['nombre_mascota']} 🐾</h2>
<p>Hola <strong>{$cita['nombre_dueno']}</strong>, hemos recibido tu solicitud de cita en la Clínica Le Mascotte.</p>

<div class="info-box">
  <div class="info-row"><span class="label">Estado</span><span class="value">{$estado}</span></div>
  <div class="info-row"><span class="label">Fecha</span><span class="value">{$fecha}</span></div>
  <div class="info-row"><span class="label">Hora</span><span class="value">{$hora}</span></div>
  <div class="info-row"><span class="label">Mascota</span><span class="value">{$cita['nombre_mascota']} ({$tipo})</span></div>
  <div class="info-row"><span class="label">Motivo</span><span class="value">{$cita['motivo_consulta']}</span></div>
  <div class="info-row"><span class="label">Veterinario</span><span class="value">Asignado al confirmar</span></div>
</div>

<div class="tip-box">
  📌 <strong>Recuerda:</strong> Llega 10 minutos antes de tu cita. Trae el carnet de vacunación de tu mascota si lo tienes.
</div>

<p>Para cancelar o reagendar tu cita, llámanos al <strong>+503 2200-0000</strong>. Emergencias disponibles 24/7.</p>
<p>¡El equipo de Le Mascotte espera a tu compañero!</p>
HTML;

        return self::send(
            $cita['email'],
            "📅 Cita confirmada para {$cita['nombre_mascota']} — Le Mascotte",
            self::template($content),
            $cita['nombre_dueno']
        );
    }

    // ─── NOTIF. INTERNA: NUEVA CITA AL ADMIN ─────────────────────
    public static function notificarAdminNuevaCita(array $cita): bool {
        $fecha    = date('d/m/Y', strtotime($cita['fecha_preferida']));
        $hora     = substr($cita['hora_preferida'], 0, 5);
        $adminUrl = APP_URL . '/admin/citas';

        $content = <<<HTML
<h2>📅 Nueva cita solicitada</h2>

<div class="info-box">
  <div class="info-row"><span class="label">Dueño</span><span class="value">{$cita['nombre_dueno']}</span></div>
  <div class="info-row"><span class="label">Teléfono</span><span class="value">{$cita['telefono']}</span></div>
  <div class="info-row"><span class="label">Email</span><span class="value">{$cita['email']}</span></div>
  <div class="info-row"><span class="label">Mascota</span><span class="value">{$cita['nombre_mascota']} ({$cita['tipo_mascota']})</span></div>
  <div class="info-row"><span class="label">Fecha solicitada</span><span class="value">{$fecha} a las {$hora}</span></div>
  <div class="info-row"><span class="label">Motivo</span><span class="value">{$cita['motivo_consulta']}</span></div>
</div>

<a href="{$adminUrl}" class="btn">Ver en el panel de citas →</a>
HTML;

        return self::send(self::REPLY_TO, "📅 Nueva cita — {$cita['nombre_dueno']} / {$cita['nombre_mascota']}", self::template($content), 'Admin Le Mascotte');
    }

    // ─── ACTUALIZACIÓN DE ESTADO DE PEDIDO ───────────────────────
    public static function actualizacionEstadoPedido(array $pedido): bool {
        if (empty($pedido['email_cliente'])) return false;

        $estados = [
            'confirmado'  => ['badge-green',  '✅ Confirmado',     'Tu pedido ha sido confirmado y está siendo preparado.'],
            'procesando'  => ['badge-blue',   '⚙️ En preparación', 'Estamos preparando tu pedido con mucho cuidado.'],
            'enviado'     => ['badge-blue',   '🚚 En camino',      'Tu pedido está en camino a tu dirección.'],
            'entregado'   => ['badge-green',  '🎉 Entregado',      '¡Tu pedido ha sido entregado! Esperamos que tus mascotas disfruten sus productos.'],
            'cancelado'   => ['badge-orange', '❌ Cancelado',      'Tu pedido ha sido cancelado. Contáctanos para más información.'],
        ];

        $info  = $estados[$pedido['estado']] ?? ['badge-orange', $pedido['estado'], ''];
        $badge = "<span class='badge {$info[0]}'>{$info[1]}</span>";
        $total = number_format($pedido['total'], 2);

        $content = <<<HTML
<h2>Actualización de tu pedido #00{$pedido['id']}</h2>
<p>Hola <strong>{$pedido['nombre_cliente']}</strong>, el estado de tu pedido ha cambiado.</p>

<div class="info-box">
  <div class="info-row"><span class="label">Pedido</span><span class="value">#00{$pedido['id']}</span></div>
  <div class="info-row"><span class="label">Nuevo estado</span><span class="value">{$badge}</span></div>
  <div class="info-row"><span class="label">Total</span><span class="value">\${$total}</span></div>
  <div class="info-row"><span class="label">Dirección</span><span class="value">{$pedido['direccion_entrega']}</span></div>
</div>

<p>{$info[2]}</p>
<p>Para cualquier consulta llámanos al <strong>+503 2200-0000</strong> o responde este correo.</p>
HTML;

        return self::send(
            $pedido['email_cliente'],
            "📦 Pedido #00{$pedido['id']}: {$info[1]} — Le Mascotte",
            self::template($content),
            $pedido['nombre_cliente']
        );
    }
}
?>
