<div class="row">
    <a href="/q8soccer/team/add" class="btn btn-primary">
        Add Team
    </a>
</div>

<div class="row">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>flag</th>
                <th>Operations</th>
            </tr>
        </thead>
        <tbody>
        <?php for ($i = 0; $i < count($data['teams']); ++$i) { ?>
            <tr>

                <td><?php echo $data['teams'][$i]->id; ?></td>
                <td><?php echo $data['teams'][$i]->name; ?></td>

                <td><img src="/q8soccer/images/flag/<?php echo $data['teams'][$i]->flag; ?>" style="height: 50px; width: 50px;"></td>
                <td>
                    <a href="/q8soccer/team/edit?id=<?php echo $data['teams'][$i]->id; ?>">
                        Edit
                    </a>
                    <a href="/q8soccer/team/delete?id=<?php echo $data['teams'][$i]->id; ?>">
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
