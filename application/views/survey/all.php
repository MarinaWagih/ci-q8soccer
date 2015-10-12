<div class="row">
    <a href="/q8soccer/survey/add" class="btn btn-primary">
        Add survey
    </a>
</div>

<div class="row">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>question</th>
                <th>user Add this</th>
                <th>Answers</th>
                <th>Operations</th>
            </tr>
        </thead>
        <tbody>
        <?php for ($i = 0; $i < count($data['surveys']); ++$i) { ?>
            <tr>

                <td><?php echo $data['surveys'][$i]->id; ?></td>
                <td><?php echo $data['surveys'][$i]->question; ?></td>
                <td><?php echo ( $data['surveys'][$i]->user_data[0]['user_name']); ?></td>
                <td><?php
                    foreach($data['surveys'][$i]->answers as $answer)
                    {
                        echo $answer['answer'] .'&nbsp;&nbsp;&nbsp;<b> No of votes:'.count($answer["answered_users"]).'</b></br>';
                    }

                    ?></td>

                <td>
                    <a href="/q8soccer/survey/edit?id=<?php echo $data['surveys'][$i]->id; ?>">
                        Edit
                    </a>
                    <a href="/q8soccer/survey/delete?id=<?php echo $data['surveys'][$i]->id; ?>">
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
