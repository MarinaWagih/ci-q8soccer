<html>
<head>
    <title>

    </title>

</head>
<body>
<div>Layout</div>
<div class="container">
    view
    <?php
    if (isset($data))
    {
        $this->load->view($content, $data);
    } else
    {
        $this->load->view($content);
    }

    ?>
</div>
</body>
</html>