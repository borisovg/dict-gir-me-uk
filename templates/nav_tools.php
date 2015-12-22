<?php

return <<<HTML
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <span class="octicon octicon-tools"></span> <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <li><a href="/dump/">Database</a></li>
            <li><a href="/log/">Logs</a></li>
        </ul>
    </li>
HTML;
