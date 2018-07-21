<?php if ($isTask && current_user_can('administrator')) :?>
    <div class="save-template" style="text-align: right; margin-top: 15px; margin-bottom: 30px">
        <button class="btn v-btn" ng-click="saveData()">Save Template</button>
    </div>
<?php endif; ?>