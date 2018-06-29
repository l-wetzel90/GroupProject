<aside>
    <ul>
        <h3>Most commented profiles</h3>
        <?php foreach ($usersSidebar as $user): ?>
            <li>
                <a href="<?php echo htmlspecialchars(".?action=view_others_profile&alias=" . $user->getAlias()) ?>">
                    <image src="<?php echo htmlspecialchars($user->getProfileImage())?>" height="30" width="30"><?php echo htmlspecialchars($user->getFullName()); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</aside>
