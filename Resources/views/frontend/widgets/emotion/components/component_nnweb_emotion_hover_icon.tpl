{block name="widgets_emotion_components_nnweb_emotion_hover_icon"}
	
	{if $Data.nnwebEmotionHoverIcon_link_produkt_id}
		{$link = {url controller="detail" sArticle=$Data.nnwebEmotionHoverIcon_link_produkt_id}}
	{else}
		{$link = $Data.nnwebEmotionHoverIcon_link}
	{/if}
	
	{if $Data.nnwebEmotionHoverIcon_link_aktivieren}
	<a class="nnweb_emotion_hover_icon" href="{$link}" target="{$Data.nnwebEmotionHoverIcon_link_target}">
	{else}
	<div class="nnweb_emotion_hover_icon">
	{/if}
		
		<div class="background-image" style="background-image:url('{$Data.nnwebEmotionHoverIcon_hintergrundbild}');background-position:{$Data.nnwebEmotionHoverIcon_hintergrundposition};"></div>
		
		<div class="wrapper" style="color:{$Data.nnwebEmotionHoverIcon_schriftfarbe};">
			
			<!-- Hintergrundfarbe extra, damit Opazität getrennt einstellbar -->
			<div class="background-color" style="background-color:{$Data.nnwebEmotionHoverIcon_hintergrundfarbe};"></div>
			
			<!-- Icon -->
			{if $Data.nnwebEmotionHoverIcon_icon_anzeigen}
			<div class="wrap-icon">
				<img src="{$Data.nnwebEmotionHoverIcon_icon}"/>
			</div>
			{/if}
			
			<!-- Headline -->
			{if $Data.nnwebEmotionHoverIcon_ueberschrift_anzeigen}
			<{$Data.nnwebEmotionHoverIcon_ueberschrift_tag} class="headline">
				{$Data.nnwebEmotionHoverIcon_ueberschrift}
			</{$Data.nnwebEmotionHoverIcon_ueberschrift_tag}>
			{/if}
			
			<!-- Text -->
			{if $Data.nnwebEmotionHoverIcon_text_anzeigen}
			<p>{$Data.nnwebEmotionHoverIcon_text}</p>
			{/if}
			
		</div>
		
	{if $Data.nnwebEmotionHoverIcon_link_aktivieren}
	</a>
	{else}
	</div>
	{/if}
	
{/block}