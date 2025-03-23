{*
{strip}
    <div class="actions">
        <span class="actionImages">
            {foreach item=RECORD_LINK from=$RECORD_LINKS}
                {include file=\App\Layout::getTemplatePath('ButtonLink.tpl', $MODULE)
            BUTTON_VIEW='listViewBasic'
            LINK_URL=$RECORD_LINK->getUrl()
            LINK_LABEL=$RECORD_LINK->getLabel()
            LINK_CLASS=$RECORD_LINK->get('linkclass')
            LINK_ICON=$RECORD_LINK->get('linkicon')}
            {/foreach}
        </span>
    </div>
{/strip}*}
