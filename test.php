<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .error {color: #FF0000;}
    </style>
</head>

<body>  

<?php
// Declarar las variables para pasar y obteber los datos de los campos del formulario y se setean vacios
$ceduErr = $nameErr = $emailErr = $dateErr = $genderErr = $ciudadErr = $websiteErr = "";
$cedula = $name = $email = $date = $gender = $comment = $ciudad = $website = "";

//validador de reporte
$v_ced = $v_nom = $v_fec = $v_ema = False;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["cedula"])) {
        $ceduErr = "Cedula es requerida";
    } else {
        $cedula = test_input($_POST["cedula"]);
        $v_ced = True;
        // Verifica si efectivamente el campo contienen o no numeros
        if (!preg_match('/^[0-9 ]{7,10}$/',$cedula)) {
          $ceduErr = "Solo se permite numeros y el tamaño minimo es 7 y maximo 8 caracteres";
        }
    } 

    if (empty($_POST["name"])) {
        $nameErr = "Nombre es requerido";
    } else {
        $name = test_input($_POST["name"]);
        $v_nam = True;
    // Verifica si el campo nombre contiene letras y espacios
        if (!preg_match("/^[a-zA-Z]+\s{1}[a-zA-Z]+$/",$name)) {
            //^([a-zA-Z]{2,}\s[a-zA-z]{1,}'?-?[a-zA-Z]{2,}\s?([a-zA-Z]{1,})?)
            ///^[a-zA-Z ]*$/
            $nameErr = "Se permite solamente dos palabras y no deben contener caracteres especiales";
        }
    }

    if (empty($_POST["date"])) {
        $dateErr = "Fecha es requerida";
    } else {
        $date = test_input($_POST["date"]);
        $v_fec = True;
        // Verifica si el campo nombre contiene letras y espacios
        if (preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $date, $matches)) {
            if (!checkdate($matches[2], $matches[1], $matches[3])) {
                $error = true;
                //echo '<error elementid="cnt_birthday" message="BIRTHDAY - Please enter a valid date in the format - dd/mm/yyyy"/>';
                $dateErr = "Se permite solo el formato de fecha";
            }
        } else {
                $error = true;
                echo '<error elementid="date" message="FECHA - Solo se permite en el formato - dd/mm/yyyy - es aceptado."/>';
        }
    }
  
    if (empty($_POST["email"])) {
        $emailErr = "Email es requerido";
    } else {
        $email = test_input($_POST["email"]);
        $v_ema = True;
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Formato invalido de fecha";
        }
    }
    
    if (empty($_POST["website"])) {
        $website = "";
    } else {
        $website = test_input($_POST["website"]);
        
        if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)) {
            $websiteErr = "URL invalido";
        }
    }

    if (empty($_POST["ciudad"])) {
        $ciudad = "";
    } else {
        $ciudad = test_input($_POST["ciudad"]);
    }

    if (empty($_POST["comment"])) {
        $comment = "";
    } else {
        $comment = test_input($_POST["comment"]);
    }

    if (empty($_POST["gender"])) {
        $genderErr = "Genero es requerido";
    } else {
        $gender = test_input($_POST["gender"]);
    }
}

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>

<h2>VALIDACION DE CAMPOS EN PHP UNIVERSIDAD LIBRE</h2>
<p><span class="error">* Campos requeridos</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  
   Cedula: <input type="text" name="cedula" value="<?php echo $cedula;?>">
  <span class="error">* <?php echo $ceduErr;?></span>
  <br><br>

  Nombre: <input type="text" name="name" value="<?php echo $name;?>">
  <span class="error">* <?php echo $nameErr;?></span>
  <br><br>
  
  Fecha de nacimiento: <input type="date" name="date" value="<?php echo $date;?>">
  <span class="error">* <?php echo $dateErr;?></span>
  <br><br>

  E-mail: <input type="text" name="email" value="<?php echo $email;?>">
  <span class="error">* <?php echo $emailErr;?></span>
  <br><br>
  
  Sitio web: <input type="text" name="website" value="<?php echo $website;?>">
  <span class="error"><?php echo $websiteErr;?></span>
  <br><br>

  Ciudad de nacimiento: <input type="text" name="ciudad" value="<?php echo $ciudad;?>">
  <span class="error"><?php echo $ciudadErr;?></span>
  <br><br>
  
  Genero:
  <input type="radio" name="gender" <?php if (isset($gender) && $gender=="female") echo "checked";?> value="femenino">Femenino
  <input type="radio" name="gender" <?php if (isset($gender) && $gender=="male") echo "checked";?> value="masculino">Masculino
  <input type="radio" name="gender" <?php if (isset($gender) && $gender=="other") echo "checked";?> value="otro">Otro
  <span class="error">* <?php echo $genderErr;?></span>
  <br><br>

  Comentario: <textarea name="comment" rows="5" cols="40"><?php echo $comment;?></textarea>
  <br><br>
  
  
  <input type="submit" name="submit" value="Enviar">  
</form>

<?php
    echo "<h2>Salida de los datos:</h2>";
    echo "Valor recibido de cedula: " . $cedula;
    echo "<br>";
    echo "Valor recibido de nombre: " .$name;
    echo "<br>";
    echo "Valor recibido de email: " .$email;
    echo "<br>";
    echo "Valor recibido de sitio web: " .$website;
    echo "<br>";
    echo "Valor recibido de comentario: " .$comment;
    echo "<br>";
    echo "Valor recibido de genero: " . $gender;
?>

</body>
</html>
