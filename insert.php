<?php 
    error_reporting(E_ALL); 
    ini_set('display_errors',1); 
    include('dbcon.php');

    $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");

    if( (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['submit'])) || $android )
    {
        // 안드로이드에서 postParameters 변수에 적어준 이름을 가지고 값을 전달 받음
        $id=$_POST['id'];
        $date=$_POST['date'];
        $state=$_POST['state'];

        if(empty($id)){
            $errMSG = "ID is Empty";
        }
        else if(empty($date)){
            $errMSG = "Date is Empty";
        }
        else if(empty($state)){
            $errMSG = "State is Empty";
        }

        if(!isset($errMSG)) // 값이 모두 입력되었다면 
        {
            try{
                // SQL문을 실행하여 데이터를 MySQL 서버의 test_table에 저장
                $stmt = $con->prepare('INSERT INTO application(id, date, state) VALUES(:id, date, state)');
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':date', $date);
                $stmt->bindParam(':state', $state);

                if($stmt->execute())
                {
                    $successMSG = "Success";
                }
                else
                {
                    $errMSG = "Error";
                }

            } catch(PDOException $e) {
                die("Database error: " . $e->getMessage()); 
            }
        }
    }
?>

<?php 
    if (isset($errMSG)) echo $errMSG;
    if (isset($successMSG)) echo $successMSG;
    $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");
    if( !$android ) {
?>
    <html>
       <body>
            <form action="<?php $_PHP_SELF ?>" method="POST">
                id: <input type = "id" problem = "id" />
                date: <input type = "id" problem = "date" />
                state: <input type = "id" problem = "state" />
                <input type = "submit" problem = "submit" />
            </form>       
       </body>
    </html>
<?php 
    }
?>