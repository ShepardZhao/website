<div id="UserList">
    <div class="row-fluid">
        <div class="span12">
            <div class="divhead"><h4><i class="icon-list-ul"> User List</i><h4></div>
            <div class="basicInfo-box">
                <div id="TableListWrap" class="text-center">
                    <?php $UserClass->DisplayDefaultUserList();?>
                </div>

                <div class="alert alert-success text-center" id="ShowMoreUsers">Display More</div>
                <div class="controls">
                    <input type="email" class="input-block-level" id="Input-Search" placeholder="Search User By Email" >
                    <button id="UserListSearch" class="button" type="button">Search</button>
                    <button id="UserListDelete" class="button" type="button">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>