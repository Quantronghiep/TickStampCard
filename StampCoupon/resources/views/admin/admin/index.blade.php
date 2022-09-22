@extends('admin.layouts.master')
@section('title','Quản lý Admin')
@section('content')
@include('admin.layouts.content_header')

<form method="GET" action="">
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" name="name" id="username"
               value="<?php echo isset($_GET['name']) ? $_GET['name'] : '' ?>" class="form-control"/>
        <input type="hidden" name="controller" value="user"/>
        <input type="hidden" name="action" value="index"/>
    </div>
    <div class="form-group">
        <input type="submit" value="Tìm kiếm" name="search" class="btn btn-primary"/>
        <a href="index.php?controller=user" class="btn btn-default">Back</a>
    </div>
</form>

<h2>Danh sách admin</h2>
<a href="index.php?controller=user&action=create" class="btn btn-success">
    <i class="fa fa-plus"></i> Thêm mới
</a>
<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>first_name</th>
        <th>last_name</th>
        <th>phone</th>
        <th>address</th>
        <th>email</th>
        <th>avatar</th>
        <th>jobs</th>
        <th>Admin</th>
        <th>created_at</th>
        <th></th>
    </tr>
    <?php if (!empty($users)): ?>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo $user['id'] ?></td>
                <td><?php echo $user['username'] ?></td>
                <td><?php echo $user['first_name'] ?></td>
                <td><?php echo $user['last_name'] ?></td>
                <td><?php echo $user['phone'] ?></td>
                <td><?php echo $user['address'] ?></td>
                <td><?php echo $user['email'] ?></td>
                <td>
                    <?php if (!empty($user['avatar'])): ?>
                        <img height="80" src="assets/uploads/<?php echo $user['avatar'] ?>"/>
                    <?php endif; ?>
                </td>
                <td><?php echo $user['jobs'] ?></td>
                <td>
                    <?php
                    $status_text = 'Yes';
                    if ($user['isAdmin'] == 0) {
                        $status_text = 'No';
                    }
                    echo $status_text;
                    ?>
                </td>
                <td><?php echo date('d-m-Y H:i:s', strtotime($user['created_at'])) ?></td>
                <td>
                    <?php
                    $url_detail = "index.php?controller=user&action=detail&id=" . $user['id'];
                    $url_update = "index.php?controller=user&action=update&id=" . $user['id'];
                    $url_delete = "index.php?controller=user&action=delete&id=" . $user['id'];
                    ?>
                    <a title="Chi tiết" href="<?php echo $url_detail ?>"><i class="fa fa-eye"></i></a> &nbsp;&nbsp;
                    <a title="Update" href="<?php echo $url_update ?>"><i class="fa fa-pencil-alt"></i></a> &nbsp;&nbsp;
                    <a title="Xóa" href="<?php echo $url_delete ?>" onclick="return confirm('Are you sure delete?')"><i
                                class="fa fa-trash"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>

@endsection