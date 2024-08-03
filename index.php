<?php
$message_sent = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoge los datos del formulario
    $name = htmlspecialchars($_POST['Name']);
    $email = htmlspecialchars($_POST['Email']);
    $message = htmlspecialchars($_POST['Message']);

    // Configura el correo electrónico
    $to = "contact@juanpendas.com"; 
    $subject = "Nuevo mensaje de contacto";
    $headers = "From: " . $email . "\r\n" .
               "Reply-To: " . $email . "\r\n" .
               "X-Mailer: PHP/" . phpversion();
    $body = "Nombre: $name\n\nEmail: $email\n\nMensaje:\n$message";

    // Envía el correo
    if (mail($to, $subject, $body, $headers)) {
        $message_sent = true;
    } else {
        $message_sent = false;
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Juan Pendas</title>
        <link rel="stylesheet" href="css/style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" href="assets/img/xpi.ico">
    </head>
    <body>
        <div class="head">
            <nav>
                <input type="checkbox" id="toggle">
                <div class="logo">
                    <a href="#">
                        <img src="assets/img/xpi.png" alt="logo" width="65">
                    </a>
                </div>
                <ul class="list">
                    <li><a href="#Rompecabezas">Rompecabezas</a></li>
                    <li><a href="#Projectos">Projectos</a></li>
                    <li><a href="#Blog">Blog</a></li>
                    <li><a href="#Contacto">Contacto</a></li>
                </ul>
                <label for="toggle" class="icon-bars">
                    <div class="line"></div>
                    <div class="line"></div>
                    <div class="line"></div>
                </label>
            </nav>
		</div>

            <div class="vContainer">
                <h1 class="JP">
                    Juan Pendás
                    <p class="par">Electronical Engineer & Attempt of Entrepreneur.</p>
                </h1>
                <img src="assets/img/ProfilePhoto.png" alt="profile-photo" width="200px" class="Profilephoto">
            </div>

            <section id="Rompecabezas">
                <h2>Rompecabezas:</h2>
                <div class="card-container">
                    <div class="card">
                        <a href="404.html">
                            <img src="assets/img/WorkInProgress02.png" alt="" class="card-img">
                            <div class="card-content">
                                <h3></h3>
                                <p class="pNoMargin"></p>
                                <h3>En desarrollo</h3>
                                <div class="progressBar" style="--wth:10%"></div>

                            </div>
                        </a>
                    </div>
                    <div class="card">
                        <a href="puzles/mirror-petal-column.html">
                            <img src="assets/img/WorkInProgress01.png" alt="" class="card-img">
                            <div class="card-content">
                                <h3>Mirror Petal Column</h3>
                                <p class="pNoMargin"></p>

                            </div>
                        </a>
                    </div>
                    <div class="card">
                        <a href="puzles/ghost-petal-column.html">
                            <img src="assets/img/puzzles/ghost-petal-column.png" alt="" class="card-img">
                            <div class="card-content">
                                <h3>Ghost Petal Column</h3>
                                <p class="pNoMargin"></p>

                            </div>
                        </a>
                    </div>
                </div>
            </section>

			<section id="Projectos">
            <h2>Otros proyectos:</h2>
            <div class="card-container">
                <div class="card">
                    <a href="sri.html">
                        <img src="assets/img/WorkInProgress03.png" alt="SRI" class="card-img">
                        <div class="card-content">
                            <h3>En desarrollo</h3>
							<div class="progressBar" style="--wth:40%"></div>
                        </div>
                    </a>
                </div>
                <div class="card">
                    <a href="assets/projects/artillery-hornet/artillery-hornet-extrusion-directa.html">
                        <img src="assets/img/WorkInProgress02.png" alt="SRI" class="card-img">
                        <div class="card-content">
                            <h3>Artillery Hornet extrusión directa</h3>
							<p class="pNoMargin">Proceso de adaptar la impresora 3D Artillery Hornet con un sistema de extrusión directa.</p>
                        </div>
                    </a>
                </div>
                <div class="card">
                    <a href="assets/projects/sri/sri.html">
                        <img src="assets/img/projects/sri.png" alt="SRI" class="card-img">
                        <div class="card-content">
                            <h3>Smart Road Infrastructure</h3>

								<div class="iconContainerNM">
										<span class="simple-icons--arduino"></span>
										<span class="simple-icons--mqtt"></span>
										<span class="simple-icons--adafruit"></span>
								</div>
                            <p class="pNoMargin">Un sistema de monitorización de tráfico en tiempo real económico.</p>
                        </div>
                    </a>
				</div>
            </div>
			</section>

			<section id="Blog">
            <h2>Blog:</h2>
                <a href="post.html?id=2024-06-21">
                    <h3>Un lavado de cara</h3>
                </a>
			</section>

            <section id="Contacto">
                <h2>Contacto:</h2>
                <div class="contactForm">
                    <form action="" method="post">
                        <p class="pNoMargin">
                            <label>Nombre</label>
                            <input type="text" name="Name" required>
                        </p>
                        <p class="pNoMargin">
                            <label>Email</label>
                            <input type="email" name="Email" required>
                        </p>
                        <p class="block">
                            <label>Mensaje</label>
                            <textarea name="Message" rows="3" required></textarea>
                        </p>
                        <p class="block">
                            <button type="submit">Enviar</button>
                        </p>
                    </form>
                    <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
                        <?php if ($message_sent): ?>
                            <div class="success">Mensaje enviado con éxito.</div>
                        <?php else: ?>
                            <div class="error">Hubo un problema al enviar el mensaje.</div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </section>     

	<script src="js/main.js"></script>
    </body>
	<iframe class="addHTML" src="assets/htmlTemplates/footer.html"></iframe>
</html>
