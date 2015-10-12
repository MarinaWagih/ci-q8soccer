
<div class="row">
    <a href="/q8soccer/prediction/add?id=1" class="btn btn-primary">
        Add prediction
    </a>
</div>

<div class="row">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Match</th>
                <th>team1 score</th>
                <th>team2 score</th>
                <th>Operations</th>
            </tr>
        </thead>
        <tbody>
        <?php for ($i = 0; $i < count($data['predictions']); ++$i) { ?>
            <tr>

                <td><?php echo $data['predictions'][$i]->id; ?></td>
                <td><?php echo $data['predictions'][$i]->team1_data['name'].' vs '.
                    $data['predictions'][$i]->team1_data['name']; ?></td>

                <td><?php echo $data['predictions'][$i]->team1_score; ?></td>
                <td><?php echo $data['predictions'][$i]->team2_score; ?></td>
                <td>
                    <a href="/q8soccer/prediction/edit?id=<?php echo $data['predictions'][$i]->id; ?>">
                        Edit
                    </a>
                    <a href="/q8soccer/prediction/delete?id=<?php echo $data['predictions'][$i]->id; ?>">
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
