<?php

SESSION_START();
include("../database.php");
$db = new Database();
$nik = (isset($_SESSION['nik']))? $_SESSION['nik'] : "";
$token = (isset($_SESSION['token']))? $_SESSION['token'] : "";

if($token && $nik)
{
	$result = $db->execute("SELECT * FROM user_tbl WHERE nik = '".$nik."' AND token = '".$token."' AND status = 1 ");
	if(!$result)
	{
       header("Location: http://localhost/course_backend/");
	}

	$userdata = $db->get("SELECT user_tbl.nik as nik, user_tbl.nama_depan as nama_depan, user_tbl.nama_belakang as nama_belakang,
                       user_tbl.alamat as alamat, user_tbl.kode_pos as kode_pos, kota_tbl.nama_kota as nama_kota,
                       provinsi_tbl.nama_provinsi as nama_provinsi
                       from user_tbl,kota_tbl, provinsi_tbl WHERE user_tbl.nik = '".$nik."' AND
                       user_tbl.kota_id = kota_tbl.kota_id AND kota_tbl.provinsi_id = provinsi_tbl.provinsi_id");               
	$userdata = mysqli_fetch_assoc($userdata);  
}
else
{
   header("Location: http://localhost/course_backend/");
}

$notification = (isset($_SESSION['notification']))? $_SESSION['notification'] : "";
if($notification)
{
   echo $notification;
   unset($_SESSION['notification']);   
}
?>

PAGE : SUBMIT SCORE
<table border=1>
	<tr>
	       <td>MENU</td>
	       <td><a href="http://localhost/course_backend/user/">HOME</a></td>
	       <td><a href="http://localhost/course_backend/user/statistik.php">STATISTIK</a></td>       
	       <td><a href="http://localhost/course_backend/user/leaderboard.php">LEADERBOARD</a></td>
	       <td><a href="http://localhost/course_backend/user/submitscore.php">SUBMIT SCORE</a></td>
	       <td><a href="http://localhost/course_backend/user/logout.php">LOGOUT</a></td>
	</tr>
</table>
<br>

<form action="http://localhost/course_backend/user/submitscore_process.php" method="POST">
	<table>
		<tr>
			<td>NIK</td>
			<td>:</td>
			<td>
				<?php echo $_SESSION['nik'] ?>
			</td>
		</tr>
		
		<tr>
			<td>Game</td>
			<td>:</td>
			<td>
				<select name="gameid" required>
				<option value="">- SELECT -</option>
				<?php
					$gamedata = $db->get("SELECT game_id,nama FROM game_tbl WHERE status=1");
					if($gamedata)
					{
						while($row = mysqli_fetch_assoc($gamedata))
						{
				?>
					<option value="<?php echo $row['game_id']?>"><?php echo $row['nama']?></option>
					<?php
						}
					}
				?>
				</select>
			</td>
		</tr>
		
		<tr>
			<td>Score</td>
			<td>:</td>
			<td>
				<textarea name="score" required></textarea>
			</td>
		</tr>
		
		<tr>
			<td colspan=3>
				<input type="submit" value="SUBMIT">
			</td>
		</tr>  
	</table>
</form>