<div class="row">
    <a href="/q8soccer/match/add" class="btn btn-primary">
        Add Match
    </a>
</div>

<div class="row">
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>team1</th>
            <th>team2</th>
            <th>Date</th>
            <th>Operations</th>

        </tr>
        </thead>
        <tbody>
        <?php for ($i = 0; $i < count($data['matches']); ++$i) { ?>
            <tr>

                <td><?php echo $data['matches'][$i]->id; ?></td>
                <td><?php echo $data['matches'][$i]->team1_data['name']; ?></td>
                <td><?php echo $data['matches'][$i]->team2_data['name']; ?></td>
                <td><?php echo $data['matches'][$i]->date; ?></td>
                <td>
                    <a href="/q8soccer/match/edit?id=<?php echo $data['matches'][$i]->id; ?>">
                        Edit
                    </a>
                    <a href="/q8soccer/match/delete?id=<?php echo $data['matches'][$i]->id; ?>">
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
