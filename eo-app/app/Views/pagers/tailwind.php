<?php if ($pager->hasPrevious() || $pager->hasNext()) : ?>

<nav class="flex justify-center mt-6">

    <ul class="flex items-center gap-2">

        <!-- PREV -->
        <?php if ($pager->hasPrevious()) : ?>

            <li>
                <a href="<?= $pager->getPreviousPageURI() ?>"
                   class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">

                    Prev

                </a>
            </li>

        <?php endif ?>

        <!-- NUMBER -->
        <?php foreach ($pager->links() as $link) : ?>

            <li>

                <a href="<?= $link['uri'] ?>"
                   class="px-4 py-2 rounded
                   <?= $link['active']
                        ? 'bg-blue-500 text-white'
                        : 'bg-gray-200 hover:bg-gray-300' ?>">

                    <?= $link['title'] ?>

                </a>

            </li>

        <?php endforeach ?>

        <!-- NEXT -->
        <?php if ($pager->hasNext()) : ?>

            <li>
                <a href="<?= $pager->getNextPageURI() ?>"
                   class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">

                    Next

                </a>
            </li>

        <?php endif ?>

    </ul>

</nav>

<?php endif ?>