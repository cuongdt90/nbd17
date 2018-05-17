<!------------------------------------------------------------------------------------
                data-animate:
                    + bottom-to-top
                    + top-to-bottom
                    + left-to-right
                    + right-to-left
                    + scale
                    + fixed-top
------------------------------------------------------------------------------------->

<div class="nbd-popup popup-share" data-animate="bottom-to-top">
    <div class="overlay-popup"></div>
    <div class="main-popup">
        <i class="icon-nbd icon-nbd-clear close-popup"></i>
        <div class="head">
            <h2><?php _e('Share this design','nbd-online-design'); ?></h2>
        </div>
        <div class="body">
            <div class="share-with">
                <span><?php _e('Share with','web-to-print-online-designer'); ?>:</span>
                <ul class="socials">
                    <li class="social facebook"><i class="icon-nbd icon-nbd-facebook-circle nbd-hover-shadow"></i></li>
                    <li class="social twitter"><i class="icon-nbd icon-nbd-twitter-circle nbd-hover-shadow"></i></li>
                    <li class="social google-plus"><i class="icon-nbd icon-nbd-google-plus-circle nbd-hover-shadow"></i></li>
                </ul>
            </div>
            <div class="share-content">
                <textarea placeholder="Write a comment"></textarea>
            </div>
            <div class="share-btn">
                <button class="nbd-button nbd-hover-shadow"><?php _e('Share now','nbd-online-design'); ?></button>
            </div>
        </div>
        <div class="footer"></div>
    </div>
</div>

<div class="nbd-popup popup-webcam" data-animate="top-to-bottom">
    <div class="overlay-popup"></div>
    <div class="main-popup">
        <i class="icon-nbd icon-nbd-clear close-popup"></i>
        <div class="head">
        </div>
        <div class="body"></div>
        <div class="footer">
            <div class="nbd-list-button">
                <button class="nbd-button"><?php _e('Pause','web-to-print-online-designer'); ?></button>
                <button class="nbd-button"><?php _e('Stop Webcam','web-to-print-online-designer'); ?></button>
                <button class="nbd-button"><?php _e('Capture','web-to-print-online-designer'); ?></button>
            </div>
        </div>
    </div>
</div>

<div class="nbd-popup popup-keyboard" data-animate="bottom-to-top">
    <div class="overlay-popup"></div>
    <div class="main-popup">
        <i class="icon-nbd icon-nbd-clear close-popup"></i>
        <div class="head">
            <span class="title"><?php _e('Keyboard shortcuts','web-to-print-online-designer'); ?></span>
        </div>
        <div class="body">
            <div class="main-body">
                <table class="keyboard-mapping">
                    <tbody>
                        <tr>
                            <th></th>
                            <th><?php _e('Site wide shortcuts','web-to-print-online-designer'); ?></th>
                        </tr>
                        <tr>
                            <td class="keys">
                                <kbd>ctrl</kbd>
                                or
                                <kbd>s</kbd>
                            </td>
                            <td><?php _e('Focus search bar','web-to-print-online-designer'); ?></td>
                        </tr>
                        <tr>
                            <td class="keys">
                                <kbd>shift</kbd>
                                or
                                <kbd>s</kbd>
                            </td>
                            <td>Focus search bar</td>
                        </tr>
                        <tr>
                            <td class="keys">
                                <kbd>Delete</kbd>
                                or
                                <kbd>s</kbd>
                            </td>
                            <td>Focus search bar</td>
                        </tr>
                        <tr>
                            <td class="keys">
                                <kbd>Delete</kbd>
                                or
                                <kbd>s</kbd>
                            </td>
                            <td>Focus search bar</td>
                        </tr>
                        <tr>
                            <td class="keys">
                                <kbd>Delete</kbd>
                                or
                                <kbd>s</kbd>
                            </td>
                            <td>Focus search bar</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
        <div class="footer"></div>
    </div>
</div>

<div class="nbd-popup popup-fileType" data-animate="bottom-to-top">
    <div class="overlay-popup"></div>
    <div class="main-popup">
        <i class="icon-nbd icon-nbd-clear close-popup"></i>
        <div class="head"></div>
        <div class="body">
            <div class="main-body"></div>
        </div>
        <div class="footer"></div>
    </div>
</div>

<div class="nbd-popup popup-term" data-animate="fixed-top">
    <div class="overlay-popup"></div>
    <div class="main-popup">
        <i class="icon-nbd icon-nbd-clear close-popup"></i>
        <div class="head"></div>
        <div class="body">
            <div class="main-body">
                Nbd term
            </div>
        </div>
        <div class="footer"></div>
    </div>
</div>