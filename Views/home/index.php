<main>
    <h2>Latest posts</h2>
    <table class="posts">
        <tr>
            <th>Title</th>
            <th>Content</th>
            <th>From</th>
            <th>Author</th>
        </tr>

        <?php
        foreach ($this->posts as $post) : ?>
            <tr>
                <td><?=$post['title']?></td>
                <td><?=$post['content']?></td>
                <td><?=$post['date_created']?></td>
                <td><a href="<?=APP_ROOT?>/users/profile/<?=$post['username']?>"><?=$post['username']?></a></td>
            </tr>
        <?php endforeach ?>
    </table>
</main>