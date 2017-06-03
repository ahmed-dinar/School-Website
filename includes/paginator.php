<?php
/**
 * Author: ahmed-dinar
 * Date: 5/31/17
 */


function showPagination($pagination, $url){  ?>

    <div class="text-center">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <li>
                    <?php if($pagination->hasPrevPage()){  ?>
                        <a href="<?php echo $url.'page='.$pagination->prevPage(); ?>" aria-label="Previous">
                    <?php }else{  ?>
                        <a href="#" class="disabled" aria-label="Previous" >
                    <?php }  ?>
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>

                <li class="<?php echo $pagination->getCurPage() == 1 ? 'active' : ''; ?>">
                    <a href="<?php echo $url.'page=1'; ?>">1</a>
                </li>

                <?php if($pagination->totalPages()>=2){ ?>
                    <li class="<?php echo $pagination->getCurPage() == 2 ? 'active' : ''; ?>">
                        <a href="<?php echo $url.'page=2'; ?>">2</a>
                    </li>
                <?php } ?>

                <?php if($pagination->totalPages()>=3){ ?>
                    <li class="<?php echo $pagination->getCurPage() == 3 ? 'active' : ''; ?>">
                        <a href="<?php echo $url.'page=3'; ?>">3</a>
                    </li>
                <?php } ?>

                <li>
                    <?php if($pagination->hasNextPage()){  ?>
                    <a href="<?php echo $url.'page='.$pagination->nextPage(); ?>" aria-label="Previous">
                        <?php }else{  ?>
                        <a href="#" class="disabled" aria-label="Previous">
                            <?php }  ?>
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                </li>
            </ul>
        </nav>
    </div>

<?php }  ?>