<div class="container">

    <div class="row mt-5">
        <div class="col">
            <h1 class="mt-4 text-center">Boards</h1>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <!-- add board -->
            <div class="board-form float-right">
                <p class="mb-0 pb-0 input-error-msg err-msg-text hide"></p>
                <input type="text" class="board-input form-control">
                <button class="board-add-btn btn btn-sm btn-primary" data-boardid="">Add</button>
                <button class="board-update-btn btn btn-sm btn-info hide">Update</button>
                <button class="board-cancel-btn btn btn-sm btn-danger hide">Cancel</button>
            </div>
            <!-- end add board -->
        </div>
        <div class="col-12 mt-5">
            <div class="boards-list text-center">

                <?php if(!empty($boards)){ ?>
                    <?php foreach ($boards as $board): ?>
                    <div class="board-container d-inline-flex" id="board-container--<?php echo $board->getId();?>">
                        <div class="board-link-container">
                            <a href="<?php echo urlHtml('/board/'.seo($board->getName()).'/'.$board->getId()); ?>" id="board-link--<?php echo $board->getId();?>">
                                <h4 class="board-name" id="board-name--<?php echo $board->getId();?>"><?php echo $board->getName();?></h4>
                            </a>
                        </div>
                        <div class="dropdown p-1">
                            <span id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-edit"></i>
                            </span>
                            <div class="dropdown-menu">
                                <a class="dropdown-item board-edit" id="board-edit--<?php echo $board->getId();?>">Edit</a>
                                <a class="dropdown-item board-delete" id="board-delete--<?php echo $board->getId();?>">Delete</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php } else {?>
                    <div id="empty-list" class="alert alert-warning">
                        <p>Your board list is empty !!</p>
                        <p>Start now and add new board fr your project!!</p>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo assets('js/boards.js');?>" defer></script>
<script>
    var g = {
        SROOT: "<?php echo urlHtml('/');?>",
        boardsModel: "board",
    };
</script>

