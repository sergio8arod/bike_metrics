<h1>Settings</h1>
<form data-bind="submit: saveSettings" id="settingsForm">
    <div class="form-group">
        <label for="favorite">Favorite module</label>
        <select data-bind="value:favorite" class="form-control" id="favorite" required>
            <?php foreach ($modules as $module):?>
                <option value="<?php echo $module['name'];?>"><?php echo $module['name'];?></option>
            <?php endforeach;?>
        </select>
    </div>
    <button type="submit" class="btn btn-default">Save</button>
</form>