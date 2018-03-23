<!DOCTYPE html>
<html lang="sl">
<meta charset="UTF-8" content="width=device-width, initial-scale=1.0">
<title>Title</title>
<header class="col-12">
    <h1>REGISTRACIJA</h1>
</header>

<div>
    <nav style="text-align: center; background-color: #ecfff8; font-size: 1.7vw">
        <ul>
                <li style="display: inline"><a href="../../../DiaGenKri/public/home">DOMOV</a></li>
        </ul>

    </nav>
    <article>

        <div align = "center">
            <div style = "width:300px; border: solid 1px #333333; " align = "left">
                <div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Registracija v sistem</b></div>

                <div style = "margin:30px">
                    <form action = "<?= "register/add/" ?>" method = "post" content="">
                        <label>Name      :</label><br><input type = "text" name = "name" class = "box"/><br /><br />
                        <label>Surname  :</label><br><input type = "text" name = "surname" class = "box" /><br/><br />
                        <label>E-mail  :</label><br><input type = "email" name = "email" class = "box"/><br /><br />
                        <label>Date of birth  :</label><input type = "date" name = "dateofbirth" class = "box"/><br /><br />
                        <label>Place of birth  :</label><input type = "text" name = "placeofbirth" class = "box" /><br/><br />
                        <label>Password  :</label><br><input type = "password" name="password1" class = "box" /><br/><br />
                        <label>Password (repeat)  :</label><input type = "password" name="password2" class = "box" /><br/><br />
                        <input type = "submit" value = " Oddaj "/><br />
                    </form>

                    <div style = "font-size:11px; color:#cc0000; margin-top:10px"></div>

                </div>

            </div>

        </div>
    </article>
</div>

