<div class="tab nbd-onload" ng-if="settings['nbdesigner_enable_clipart'] == 'yes'" id="tab-svg" nbd-scroll="scrollLoadMore(container, type)" data-container="#tab-svg" data-type="clipart" data-offset="20">
    <div class="nbd-search">
        <input type="search" name="search" placeholder="search" ng-model="resource.clipart.filter.search"/>
        <i class="icon-nbd icon-nbd-fomat-search"></i>
    </div>
    <div class="cliparts-category">
        <button class="nbd-button nbd-dropdown">
            <span>{{resource.clipart.filter.currentCat.name}}</span>
            <i class="icon-nbd icon-nbd-chevron-right rotate90"></i>
            <div class="nbd-sub-dropdown" data-pos="center">
                <ul class="nbd-perfect-scroll">
                    <li ng-click="changeCat('clipart', cat)" ng-repeat="cat in resource.clipart.data.cat"><span>{{cat.name}}</span><span>{{cat.amount}}</span></li>
                </ul>
            </div>
        </button>
    </div>
    <div class="tab-main tab-scroll">
        <div class="nbd-items-dropdown" style="padding:10px;">
            <div>
                <div class="clipart-wrap">
                    <div class="clipart-item"  ng-repeat="art in resource.clipart.filteredArts | limitTo: resource.clipart.filter.currentPage * resource.clipart.filter.perPage" repeat-end="onEndRepeat('clipart')">
                        <img  ng-src="{{art.url}}" ng-click="addArt(art)">
                    </div>
                </div>
                <div class="loading-photo" style="width: 40px; height: 40px;">
                    <svg class="circular" viewBox="25 25 50 50">
                        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
                    </svg>
                </div>                 
            </div>
        </div>
    </div>
</div>
