<?php if ($pager->hasPrevious() || $pager->hasNext()) : ?>

<div class="flex justify-center mt-8">

    <nav class="flex items-center gap-2">

        <!-- PREVIOUS -->
        <?php if ($pager->hasPrevious()) : ?>

            <a href="<?= $pager->getPreviousPageURI() ?>"
               class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">

               Previous

            </a>

        <?php endif ?>

        <!-- PAGE NUMBER -->
        <?php foreach ($pager->links() as $link) : ?>

            <a href="<?= $link['uri'] ?>"
               class="px-4 py-2 rounded-lg
               <?= $link['active']
                    ? 'bg-blue-500 text-white'
                    : 'bg-gray-200 hover:bg-gray-300' ?>">

                <?= $link['title'] ?>

            </a>

        <?php endforeach ?>

        <!-- NEXT -->
        <?php if ($pager->hasNext()) : ?>

            <a href="<?= $pager->getNextPageURI() ?>"
               class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">

               Next

            </a>

        <?php endif ?>

    </nav>

</div>

<?php endif ?>