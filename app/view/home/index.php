<!DOCTYPE html>
<html lang="sl">
<meta charset="UTF-8" content="width=device-width, initial-scale=1.0">
<title>Title</title>
<header class="col-12">
    <h1>SPLETNA BANKA </h1>
</header>

<div class="row">
    <nav>
        <ul>
            <?php if(isset($_SESSION["uporabnik"])): ?>
            <?php else: ?>
                <li style="display: inline"><a href="../../../DiaGenKri/public/login">PRIJAVA</a></li>
                <li style="display: inline"><a href="../../../DiaGenKri/public/register">REGISTRACIJA</a></li>
            <?php endif; ?>
        </ul>

    </nav>