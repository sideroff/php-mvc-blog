<main>
    <h2>Latest posts</h2>
    <table class="posts">
        <tr>
            <th>Post №</th>
            <th>Title</th>
            <th>Content</th>
            <th>From</th>
            <th>Author</th>
        </tr>

        <?php
        foreach ($this->posts as $post) : ?>
            <tr>
                <td><?=$post['id']?></td>
                <td><a href="<?=APP_ROOT?>/posts/index/<?=$post['id']?>"><?=$post['title']?></a></td>
                <td><?=$post['content']?></td>
                <td><?=$post['date_created']?></td>
                <td><a href="<?=APP_ROOT?>/users/profile/<?=$post['username']?>"><?=$post['username']?></a></td>
            </tr>
        <?php endforeach ?>
    </table>
    <span class="latest-user">Say hi to our latest user: <a href="<?=APP_ROOT?>/users/profile/<?=$this->latestUserRegisteredUsername?>"><?=$this->latestUserRegisteredUsername?></span>
</main>