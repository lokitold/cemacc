     
<?php if ($this->pageCount): ?>
    <div class="pagination" style="margin-top: 0px;">
        <ul>
            <li>
                <a 
                    href="<?php echo $this->url(array('concesionario' => $this->concesionario,'page' => 1,));?>"
                    class="<?php echo ($this->current == 1)? 'disabled':'' ?>"
                    ><<
                </a>
            </li>
            
            <!-- Numbered page links -->
                <?php foreach ($this->pagesInRange as $page): ?>
                    <?php if ($page != $this->current): ?>
                    <li><a href="<?php
                           echo $this->url(array(
                               'concesionario' => $this->concesionario,
                               'page' => $page,
                           ));
                           ?>">
                    <?php echo $page; ?>
                        </a></li>
                    <?php else: ?>
                        <?php echo '<li class="active"><a>' . $page . '</a></li>'; ?>
                    <?php endif; ?>
                   <?php endforeach; ?>
            
            <li>
                <a 
                    href="<?php echo $this->url(array('concesionario' => $this->concesionario,'page' => $this->pageCount,));?>"
                    class="<?php echo ($this->current == $this->pageCount)? 'disabled':'' ?>"
                   >
                    >>
                </a>
            </li>
        </ul>
    </div>
<?php endif; ?>
