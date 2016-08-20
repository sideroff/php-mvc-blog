<main>
    <table class="posts">
        <tr>
            <th>Title</th>
            <th>Content</th>
            <th>From</th>
            <th>Author</th>
        </tr>

        <?php
        var_dump($_SESSION);
        foreach ($this->posts as $post) : ?>
            <tr>
                <td><?=$post['title']?></td>
                <td><?=$post['content']?></td>
                <td><?=$post['date']?></td>
                <td><?=$post['author_id']?></td>
            </tr>
        <?php endforeach ?>
    </table>
</main>