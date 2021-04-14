<div class="container">

    <input type="hidden" value="1" class="user-id">

    <div class="row">
        <div class="col">
            <h1 class="mt-4 text-center">Boards</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <!-- add board -->
            <div class="board-form float-right">
                <input type="text" class="board-input form-control">
                <p class="input-error-msg err-msg-text hide"></p>
                <button class="board-add-btn btn btn-sm btn-primary" data-boardid="">Add</button>
                <button class="board-update-btn btn btn-sm btn-info hide">Update</button>
                <button class="board-cancel-btn btn btn-sm btn-danger hide">Cancel</button>
            </div>
            <!-- end add board -->
        </div>
        <div class="col-12">
            <div class="boards-list text-center">
                <?php foreach ($boards as $board): ?>
                    <div class="board-container d-inline-flex" id="board-container--<?=$board->getId()?>">
                        <div class="board-link-container">
                            <a href="<?= urlHtml('/boards/'.seo($board->getName()).'/'.$board->getId()); ?>" id="board-link--<?=$board->getId()?>">
                                <h4 class="board-name" id="board-name--<?=$board->getId()?>"><?=$board->getName()?></h4>
                            </a>
                        </div>
                        <div class="dropdown p-1">
                            <span id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-edit"></i>
                            </span>
                            <div class="dropdown-menu">
                                <a class="dropdown-item board-edit" id="board-edit--<?=$board->getId()?>">Edit</a>
                                <a class="dropdown-item board-delete" id="board-delete--<?=$board->getId()?>">Delete</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?= assets('js/boards.js')?>" defer></script>
<script>
    var g = {
        SROOT: "<?=urlHtml('/')?>",
        boardsModel: "boards",
    };
</script>

