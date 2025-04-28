<?php
	include('conexion.php')
?>

<html>
	<head>
	</head>

	<body>
		<div id="divEncuesta">
			<h3>Vota por tu equipo favorito</h3>
			<form method='post' action="votar.php" onsubmit="return validarFormulario()">
				<?php
					$sql = "SELECT e.id, e.nombre,
							(SELECT COUNT(*) FROM voto v WHERE v.equipo = e.id) AS total
							FROM equipo e";

					$rs = mysqli_query($con, $sql);
					while($fila = mysqli_fetch_assoc($rs)){
						echo "	<div>
								<label><input type='radio' value='{$fila['id']}' name='rdVoto'/>{$fila['nombre']} </label>({$fila['total']} votos)
								</div>
						";
					}
				?>
				<button type="submit">Votar</button>
			</form>
		</div>
	</body>

	<script src="script.js"></script>

</html>