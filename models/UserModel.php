<?PHP
require_once("BaseModel.php");

class UserModel extends BaseModel
{

    function __construct()
    {
        if (!static::$db) {
            static::$db = mysqli_connect($this->host, $this->username, $this->password, $this->db_name);
        }
        mysqli_set_charset(static::$db, "utf8");
    }

    function getUserLogin($user_username = '', $user_password = '')
    {
        $sql = " SELECT *
        FROM tb_user
        WHERE user_username = '" . $user_username . "'  
        AND user_password = '" . $user_password . "'  
        ";
       
        if ($result = mysqli_query(static::$db, $sql, MYSQLI_USE_RESULT)) {
            $data = [];
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $data['data'] = $row;
            }
            $data['require'] = true;
            $result->close();
            return $data;
        } else {
            return $sql;
        }
    }

    function getUserBy($data = [])
    {
        $condition = '';
        if (isset($data['keyword'])) {
            $data['keyword'] = "WHERE (user_code LIKE ('%" . $data['keyword'] . "%'))";
        } else {
            $data['keyword'] = 'WHERE 1';
        }
        if (isset($data['user_position_code']) && isset($data['user_position_code'])) {
            $condition += `AND ` . $data['user_position_code'] . ` =  ` . $data['user_position_code'];
        }
        $sql = "SELECT * , CONCAT(tb_user.user_name,' ',tb_user.user_lastname) as user_full_name ,
                position_name as user_position_name ,
                tb_user.user_position_code as user_position_code ,
                license_name as license_name ,
                user_tel 
                FROM tb_user 
                LEFT JOIN tb_license ON tb_user.license_code = tb_license.license_code
                LEFT JOIN tb_position ON tb_user.user_position_code = tb_position.position_code
                " . $data['keyword'];
        if ($result = mysqli_query(static::$db, $sql, MYSQLI_USE_RESULT)) {
            $data = [];
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $data[] = $row;
            }
            $sql = "SELECT COUNT(*) AS total
                FROM tb_user 
                LEFT JOIN tb_license ON tb_user.license_code = tb_license.license_code
                LEFT JOIN tb_position ON tb_user.user_position_code = tb_position.position_code
                " . $data['keyword'] . $condition;
            if ($result = mysqli_query(static::$db, $sql, MYSQLI_USE_RESULT)) {
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    $data += $row;
                }
            }
            $result->close();
            return $data;
        }
    }
    function getUserByCode($code)
    {
        $sql = "SELECT 
                * ,
                CONCAT(tb_user.user_name,' ',tb_user.user_lastname) as user_full_name ,
                position_name as user_position_name ,
                tb_user.user_position_code as user_position_code ,
                license_name as license_name ,
                user_tel 
                FROM tb_user 
                LEFT JOIN tb_license ON tb_user.license_code = tb_license.license_code
                LEFT JOIN tb_position ON tb_user.user_position_code = tb_position.position_code
                WHERE 
                tb_user.user_code ='$code'
                ";


        if ($result = mysqli_query(static::$db, $sql, MYSQLI_USE_RESULT)) {
            $data = [];
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $data[] = $row;
            }
            $result->close();
            return $data;
        }
    }
    function getUserByPosition($position)
    {
        $sql = "SELECT 
                * ,
                CONCAT(tb_user.user_name,' ',tb_user.user_lastname) as user_full_name ,
                position_name as user_position_name ,
                tb_user.user_position_code as user_position_code ,
                license_name as license_name ,
                user_tel 
                FROM tb_user 
                LEFT JOIN tb_license ON tb_user.license_code = tb_license.license_code
                LEFT JOIN tb_position ON tb_user.user_position_code = tb_position.position_code
                WHERE 
                tb_user.user_position_code ='$position'
                ";


        if ($result = mysqli_query(static::$db, $sql, MYSQLI_USE_RESULT)) {
            $data = [];
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $data[] = $row;
            }
            $result->close();
            return $data;
        }
    }
    function getUserMaxCode($code)
    {

        $sql = "SELECT CONCAT('$code' , LPAD(IFNULL(MAX(CAST(SUBSTRING(user_code,10,3) AS SIGNED)),0) + 1,3,'0' )) AS  user_maxcode 
        FROM tb_user
        WHERE user_code LIKE ('%U%') 
        ";
        if ($result = mysqli_query(static::$db, $sql, MYSQLI_USE_RESULT)) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $result->close();
            return $row['user_maxcode'];
        }
    }

    function insertUser($data = [])
    {
        $sql = " INSERT INTO tb_user ( 
            user_code,
            user_prefix,
            user_name,
            user_profile_image,
            user_lastname,
            user_tel,
            user_email, 
            user_username,
            user_password,
            user_address,
            user_zipcode,
            user_position_code,
            license_code,
            station_code,
            addby,
            adddate,
            user_status
            )  VALUES ('" .
            $data['user_code'] . "','" .
            $data['user_prefix'] . "','" .
            $data['user_name'] . "','" .
            $data['user_profile_image'] . "','" .
            $data['user_lastname'] . "','" .
            $data['user_tel'] . "','" .
            $data['user_email'] . "','" .
            $data['user_username'] . "','" .
            $data['user_password'] . "','" .
            $data['user_address'] . "','" .
            $data['user_zipcode'] . "','" .
            $data['user_position_code'] . "','" .
            $data['license_code'] . "','" .
            $data['user_station'] . "','" .
            $data['addby'] . "',
            NOW(),'" .
            $data['user_status'] . "'); 
        ";
        return mysqli_query(static::$db, $sql, MYSQLI_USE_RESULT);
    }

    function updateUserBy($code, $data = [])
    {
        $sql = " UPDATE tb_user SET 
        
        user_profile_image = '" . static::$db->real_escape_string($data['user_profile_image']) . "',  
        user_code = '" . static::$db->real_escape_string($data['user_code']) . "',  
        user_prefix = '" . static::$db->real_escape_string($data['user_prefix']) . "', 
        user_name = '" . static::$db->real_escape_string($data['user_name']) . "', 
        user_lastname = '" . static::$db->real_escape_string($data['user_lastname']) . "', 
        user_tel = '" . static::$db->real_escape_string($data['user_tel']) . "', 
        user_email = '" . static::$db->real_escape_string($data['user_email']) . "', 
        user_username = '" . static::$db->real_escape_string($data['user_username']) . "', 
        user_password = '" . static::$db->real_escape_string($data['user_password']) . "', 
        user_address = '" . static::$db->real_escape_string($data['user_address']) . "', 
        user_zipcode = '" . static::$db->real_escape_string($data['user_zipcode']) . "', 
        user_position_code = '" . static::$db->real_escape_string($data['user_position_code']) . "',
        station_code = '" . static::$db->real_escape_string($data['user_station']) . "', 
        license_code = '" . static::$db->real_escape_string($data['license_code']) . "', 
        updateby = '" . static::$db->real_escape_string($data['updateby']) . "', 
        user_status = '" . static::$db->real_escape_string($data['user_status']) . "',
        lastupdate=NOW() 
        WHERE user_code = '" . static::$db->real_escape_string($code) . "'
        ";

        if (mysqli_query(static::$db, $sql, MYSQLI_USE_RESULT)) {
            return true;
        } else {
            return false;
        }
    }

    function deleteUserByCode($code)
    {
        $sql = " DELETE FROM tb_user WHERE user_code = '$code' ";
        return mysqli_query(static::$db, $sql, MYSQLI_USE_RESULT);
    }
}
