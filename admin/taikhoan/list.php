<div class="row">
    <div class="row frmtitle">
        <H1>Danh sách tài khoản</H1>
    </div>
    <div class="row frmcontent">
        <div class="row mb10 frmdsloai">
            <table>
                <tr>
                    <th></th>
                    <th>Mã tài khoản</th>
                    <th>Tên đăng nhập</th>
                    <th>Mật khẩu</th>
                    <th>Email</th>
                    <th>Địa chỉ</th>
                    <th>Điện thoại</th>
                    <th>Vai trò</th>


                    <th></th>
                </tr>
                <?php 
                foreach($listtaikhoan as $taikhoan){
                 $suatk = "index.php?act=suatk&id=".$taikhoan["id"];
                 $xoatk = "index.php?act=xoatk&id=".$taikhoan["id"];
                   ?>
                <tr>
                    <td><input type="checkbox" name="" id=""></td>
                    <td><?php echo $taikhoan["id"];?></td>
                    <td><?php echo $taikhoan["user"];?></td>
                    <td><?php echo $taikhoan["pass"];?></td>
                    <td><?php echo $taikhoan["email"];?></td>
                    <td><?php echo $taikhoan["address"];?></td>
                    <td><?php echo $taikhoan["tel"];?></td>
                    <td><?php echo $taikhoan["role"];?></td>

                    <td><a href="<?=$suatk?>"><input type="button" value="Sửa"></a>
                        <a href="<?=$xoatk?>"><input type="button" value="Xoá"></a>
                    </td>
                </tr>
                <?php
                }
                ?>
            </table>
        </div>

        <div class=" row mb10">
            <input type="button" value="Chọn Tất Cả">
            <input type="button" value="Bỏ chọn tất cả">
            <input type="button" value="Xoá các mục đã chọn">
            <a href="index.php?act=addtk"><input type="button" value="Nhập thêm"></a>
        </div>
    </div>
</div>