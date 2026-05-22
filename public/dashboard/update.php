<?php include("../templates/header.php"); ?>


<?php
    if($_POST){
        require("../../conn.php");
        if($_POST["posttype"] == "Update"){
            echo "Update";
            $user_id = 1;

            $sql = "UPDATE Library SET book_status = ?, book_page = ?, book_notes = ? WHERE book_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sisi", $_POST["update_status"], $_POST["update_page"], $_POST["update_notes"], $_POST["update_id"]);
            $stmt->execute();
            $stmt->close();

            if($_POST["old_update_page"] != $_POST["update_page"]){ // för att endast skicka updates till activity när sidonummer ändras

                $sql = "INSERT INTO Activity (user_id, book_id) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ii", $user_id, $_POST["update_id"]);
                $stmt->execute();
                $stmt->close();
            }

            header("Location: index.php");
            exit();
        }
    }
    
    $sql = "SELECT * FROM Library
    INNER JOIN Books on Library.book_id = Books.book_id
    WHERE Books.book_id=" . $_GET["id"];
    
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){ 
            $isComplete = $row["book_status"] === "Complete";?>

            <form method="post" enctype="multipart/form-data" class="input">
                <input 
                    type="text" 
                    name="update_id" 
                    value="<?php echo $row["book_id"]?>" 
                    hidden>
                <input 
                    type="text" 
                    name="update_name"
                    value="<?php echo $row["book_name"];?>"
                    readonly
                    class="read-only">
                <textarea 
                    name="update_description"
                    readonly
                    class="read-only"><?php echo $row["book_description"];?></textarea>
                <div class="Radio">
                    <div>
                        <label>Reading</label>
                        <input 
                            type="radio" 
                            name="update_status" 
                            value="Reading"
                            <?php if($row["book_status"] == "Reading") echo "checked"; ?>
                            <?php if($isComplete) echo "disabled"; ?>>
                    </div>
                    <div>
                        <label>Plan to Read</label>
                        <input 
                            type="radio" 
                            name="update_status" 
                            value="Plan to Read"
                            <?php if($row["book_status"] == "Plan to Read") echo "checked"; ?>
                            <?php if($isComplete) echo "disabled"; ?>>
                    </div>
                    <div>
                        <label>On Hold</label>
                        <input 
                            type="radio" 
                            name="update_status" 
                            value="On Hold"
                            <?php if($row["book_status"] == "On Hold") echo "checked"; ?>
                            <?php if($isComplete) echo "disabled"; ?>>
                    </div>
                    <div>
                        <label>Dropped</label>
                        <input 
                            type="radio" 
                            name="update_status" 
                            value="Dropped"
                            <?php if($row["book_status"] == "Dropped") echo "checked"; ?>
                            <?php if($isComplete) echo "disabled"; ?>>
                    </div>
                </div>
                <input 
                    type="number"
                    name="update_page"
                    min="0"
                    value="<?php echo $row["book_page"];?>"
                    <?php if($isComplete) echo "readonly"; ?>>
                <input 
                    type="number"
                    name="old_update_page"
                    value="<?php echo $row["book_page"];?>"
                    hidden>
                <textarea 
                    name="update_notes"
                    <?php if($isComplete) echo "readonly"; ?>
                    ><?php echo $row["book_notes"];?></textarea>
                <?php if($isComplete){ ?>
                    <textarea 
                        name="complete_review" readonly
                        ><?php echo $row["book_review"];?></textarea>
                <?php } ?>

                <?php if(!$isComplete){ ?>
                    <input class="btn btn-primary" type="submit" name="posttype" value="Update">
                    <a 
                        class="btn btn-primary"
                        href="complete.php?id=<?php echo $row["book_id"]; ?>">
                        Complete
                    </a>
                <?php } ?>

            </form>
        <?php
        }   
    }
    ?> 
    
<?php include("../templates/footer.php"); ?>