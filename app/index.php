<?php
include "php/config.php";
$new_url = "";
if(isset($_GET)){
	foreach($_GET as $key=>$val){
		if ($key === "code") {
			$u = mysqli_real_escape_string($conn, $val);
			$new_url = str_replace('/', '', $u);
		}
	}

	$sql = mysqli_query($conn, "SELECT full_url FROM url WHERE shorten_url = '{$new_url}'");
	if(mysqli_num_rows($sql) > 0){
		$sql2 = mysqli_query($conn, "UPDATE url SET clicks = clicks + 1 WHERE shorten_url = '{$new_url}'");
		if($sql2){
			$full_url = mysqli_fetch_assoc($sql);
			header("Location:".$full_url['full_url']);
		}
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>URL Shortener in PHP | CodingNepal</title>
    <link rel="stylesheet" href="app/style.css">
    <!-- Iconsout Link for Icons -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.6/css/line.css">
</head>
<body>
<div class="wrapper">
<!--    mutil url form-->
    <form class="mutil-url" action="#" method="post" autocomplete="off">
        <textarea spellcheck="false" name="mutil_url" placeholder="Copy/ Paste đoạn văn bản muốn extract URL" rows="4" cols="50" required></textarea>
        <button>Rút gọn</button>
    </form>

    <form class="single-url" action="#" autocomplete="off">
        <input type="text" spellcheck="false" name="full_url" placeholder="Enter or paste a long url" required>
        <i class="url-icon uil uil-link"></i>
        <button>Rút gọn</button>
    </form>
	<?php
	$sql2 = mysqli_query($conn, "SELECT * FROM url ORDER BY id DESC");
	if(mysqli_num_rows($sql2) > 0){;
		?>
        <div class="statistics">
			<?php
			$sql3 = mysqli_query($conn, "SELECT COUNT(*) FROM url");
			$res = mysqli_fetch_assoc($sql3);

			$sql4 = mysqli_query($conn, "SELECT clicks FROM url");
			$total = 0;
			while($count = mysqli_fetch_assoc($sql4)){
				$total = $count['clicks'] + $total;
			}
			?>
            <span>Total Links: <span><?php echo end($res) ?></span> & Total Clicks: <span><?php echo $total ?></span></span>
<?php if (false) { ?>            
 <a href="app/php/delete.php?delete=all">Clear All</a>
<?php } ?>
        </div>
        <div class="urls-area">
            <div class="title">
                <li>Shorten URL</li>
                <li>Original URL</li>
                <li>Clicks</li>
                <li>Action</li>
            </div>
			<?php
			while($row = mysqli_fetch_assoc($sql2)){
				?>
                <div class="data">
                    <li>
                        <a href="<?php echo $protocol."://".$domain.$row['shorten_url'] ?>" target="_blank">
							<?php
							if($domain.strlen($row['shorten_url']) > 50){
								echo $domain.substr($row['shorten_url'], 0, 50);
							}else{
								echo $domain.$row['shorten_url'];
							}
							?>
                        </a>
                        <input type="text" value="<?php echo $domain.$row['shorten_url'];?>">
                        <i class="single-copy-icon uil uil-copy-alt"></i>
                    </li>
                    <li>
						<?php
						if(strlen($row['full_url']) > 60){
							echo substr($row['full_url'], 0, 60);
						}else{
							echo $row['full_url'];
						}
						?>
                    </li>
                    </li>
                    <li><?php echo $row['clicks'] ?></li>
                    <li><?php if (false) { ?><a href="app/php/delete.php?id=<?php echo $row['shorten_url'] ?>">Delete</a><?php } ?></li>
                </div>
				<?php
			}
			?>
        </div>
		<?php
	}
	?>
</div>

<div class="blur-effect"></div>
<div class="popup-box">
    <div class="info-box">Your short link is ready. You can also edit your short link now but can't edit once you saved it.</div>
    <form class="edit-url" action="#" autocomplete="off">
        <label>Edit your shorten url</label>
        <input type="text" class="shorten-url" spellcheck="false" required>
        <i class="copy-icon uil uil-copy-alt"></i>
        <button>Save</button>
    </form>
</div>

<div class="multil-popup-box">
    <form class="edit-url" action="#" autocomplete="off">
        <label>Edit your shorten url</label>
        <textarea spellcheck="false" name="mutil_url"  rows="4" cols="50" required></textarea>
        <i class="copy-icon uil uil-copy-alt"></i>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.10/clipboard.min.js"></script>
<script src="app/script.js"></script>
<script src="app/mutil-url.js"></script>

</body>
</html>

