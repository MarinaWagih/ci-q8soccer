<div class="row">
    <a href="/q8soccer/user/add" class="btn btn-primary">
        Add User
    </a>
</div>

<div class="row">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
            <th>#</th>
            <th>user Name</th>
            <th>e-mail</th>
            <th>type</th>
            <th>Operations</th>

        </tr>
        </thead>
        <tbody>
        <?php for ($i = 0; $i < count($data['users']); ++$i) { ?>
            <tr>

                <td><?php echo $data['users'][$i]->id; ?></td>
                <td><?php echo $data['users'][$i]->user_name; ?></td>
                <td><?php echo $data['users'][$i]->email; ?></td>
                <td><?php echo $data['users'][$i]->type; ?></td>
                <td>
                    <a href="/q8soccer/user/edit?id=<?php echo $data['users'][$i]->id; ?>">
                        Edit
                    </a>
                    <a href="/q8soccer/user/delete?id=<?php echo $data['users'][$i]->id; ?>">
                       Delete
                    </a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <div class="row">
        <div class="col-md-12 text-center">
            <?php echo $data['pagination']; ?>
        </div>
    </div>
</div>
