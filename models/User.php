<?php

class User extends DB {
  public $user;
  public $id;
  public $ids;
  

  function getAll($startIndex = 0 , $pageSize = 8){  //read所有user資料
    return $this->selectDB("SELECT * FROM User ORDER BY UserID ASC LIMIT ?,? ;",
    [$startIndex, $pageSize]  
  );
  }

  function getUserById($id){
    return $this->selectDB(
      "SELECT * FROM User WHERE UserID = ? ;",[$id])[0];
  }

  function getCourseStudentById($id){ //userDetail 課程欄位
    if(!empty($this->selectDB("SELECT UserID FROM Student WHERE UserID = $id ;"))){
      return $this->selectDB(
        "SELECT C.Title , S.CourseID FROM Student S 
        JOIN Course C ON S.CourseID = C.CourseID 
        WHERE S.UserID = ? ;",[$id])[0];
    }
  }

  function getCouponById($id){ //userDetail coupon欄位
    if(!empty($this->selectDB("SELECT UserID FROM UserCoupon WHERE UserID = $id ;"))){
      return $this->selectDB(
        "SELECT C.CouponName , C.CouponID FROM Coupon C
        JOIN UserCoupon U ON C.CouponID = U.CouponID
        WHERE U.UserID = ? ;",[$id])[0];
    }
  }


  function getAllCount(){
    return $this->selectDB("SELECT COUNT(*) as Total FROM User;")[0];
  }

  function getAllLike($column,$search,$startIndex = 0 ,$pageSize = 8){
    return $this->selectDB(
      "SELECT * FROM User WHERE $column LIKE CONCAT('%',?,'%') ORDER BY UserID ASC LIMIT ?,?  ;" ,
      [$search, $startIndex, $pageSize]
    );
  }

  function getAllLikeCount($column,$search){
    return $this->selectDB(
      "SELECT COUNT(*) Count FROM User WHERE $column LIKE CONCAT('%',?,'%') ;",
      [$search]
    )[0];
  }


  function createUser($user){  //add新增會員  
    return $this->insertDB(
        "INSERT INTO User (UserName , NickName , Gender , Birthdate , Phone,
        Email , Password , Country , City , District , Address , CreateDate) 
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?) ;", ["$user->UserName" , "$user->NickName" ,
        $user->Gender , $user->Birthdate , "$user->Phone" , "$user->Email" , $user->Password ,
        "$user->Country" , "$user->City" , "$user->District" , "$user->Address" ,
        $user->CreateDate]
    );
  }


  function updateUser($user){  //修改會員
    return $this->updateDB(
      "UPDATE User SET UserName=? , NickName=? , Gender=? , Birthdate=? , Phone=?,
      Email=? , Password=? , Country=? , City=? , District=? , Address=? , PostalCode=? ,CreateDate=? WHERE UserID = ?;"
      ,["$user->UserName" , "$user->NickName" ,$user->Gender , $user->Birthdate , "$user->Phone" , "$user->Email" , $user->Password ,
      "$user->Country" , "$user->City" , "$user->District" , "$user->Address" , "$user->PostalCode" ,
      $user->CreateDate , $user->UserID]);

  }


  function deleteUser($ids = []){  //刪除會員
    return $this->deleteDB(
      "DELETE FROM User WHERE UserID IN (" .str_repeat("?," , count($ids) -1 ). "?);", 
      $ids);
  }
 
}

?>
