<?php
namespace nnwebEmotionHoverIcon;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\ActivateContext;
use Shopware\Components\Plugin\Context\DeactivateContext;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UpdateContext;
use Doctrine\Common\Collections\ArrayCollection;

class nnwebEmotionHoverIcon extends Plugin {
	private $pluginname = 'nnwebEmotionHoverIcon';

	public static function getSubscribedEvents() {
		return [
				'Enlight_Controller_Action_PostDispatchSecure_Widgets_Emotion' => 'extendsEmotionTemplates',
				'Enlight_Controller_Action_PostDispatchSecure_Backend_Emotion' => 'onPostDispatchBackendEmotion',
				'Theme_Compiler_Collect_Plugin_Less' => 'addLessFiles'
		];
	}

	public function activate(ActivateContext $context) {
		$context->scheduleClearCache(InstallContext::CACHE_LIST_ALL);
		parent::activate($context);
	}

	public function deactivate(DeactivateContext $context) {
		$context->scheduleClearCache(InstallContext::CACHE_LIST_ALL);
		parent::deactivate($context);
	}

	public function update(UpdateContext $context) {
		$context->scheduleClearCache(InstallContext::CACHE_LIST_ALL);
		parent::update($context);
	}

	public function install(InstallContext $context) {
		$this->registerEmotionElement();
		parent::install($context);
	}

	private function registerEmotionElement() {
		$emotionComponentInstaller = $this->container->get('shopware.emotion_component_installer');
		
		$element = $emotionComponentInstaller->createOrUpdate($this->getName(), $this->pluginname, [
			'name' => 'Hover mit Icon',
			'template' => 'component_nnweb_emotion_hover_icon',
			'xtype' => 'emotion-components-nnweb-emotion-hover_icon',
			'cls' => 'nnweb-emotion-hover_icon'
		]);
		
		// Link
		$element->createDisplayField([
			'name' => 'link',
			'defaultValue' => 'Link',
			'supportText' => '',
			'allowBlank' => true
		]);
		
		$element->createCheckboxField([
			'name' => $this->pluginname . '_link_aktivieren',
			'fieldLabel' => 'Aktivieren'
		]);
		
		$element->createTextField([
			'name' => $this->pluginname . '_link',
			'fieldLabel' => 'Link',
			'defaultValue' => '',
			'supportText' => 'Sie können hier einen Hyperlink definieren.',
			'allowBlank' => true,
			'translatable' => true
		]);
		
		$element->createField([
			'name' => $this->pluginname . '_link_artikel',
			'fieldLabel' => 'Link auf Artikel',
			'xtype' => 'emotion-components-fields-article',
			'supportText' => 'Wird hier ein Artikel ausgewählt, wird der obige Link überschrieben.',
			'allowBlank' => true
		]);
		
		$element->createComboBoxField([
			'fieldLabel' => 'Link öffnen in',
			'name' => $this->pluginname . '_link_target',
			'supportText' => 'Sie können hier festlegen, wo der Link geöffnet wird.',
			'allowBlank' => false,
			'store' => 'Shopware.apps.nnwebEmotionHoverIcon.store.LinkTargetStore',
			'queryMode' => 'local',
			'displayField' => 'name',
			'valueField' => 'value',
			'defaultValue' => '_self'
		]);
		
		// Icon
		$element->createDisplayField([
			'name' => 'icon',
			'defaultValue' => 'Icon',
			'supportText' => '',
			'allowBlank' => true
		]);
		
		$element->createCheckboxField([
			'name' => $this->pluginname . '_icon_anzeigen',
			'fieldLabel' => 'Anzeigen'
		]);
		
		$element->createMediaField([
			'name' => $this->pluginname . '_icon',
			'fieldLabel' => 'Icon',
			'supportText' => 'Bitte wählen Sie ein Icon aus der Media-Verwaltung.',
			'allowBlank' => true,
			'translatable' => true,
			'valueField' => 'path'
		]);
		
		// Hintergrund
		$element->createDisplayField([
			'name' => 'hintergrund',
			'defaultValue' => 'Hintergrund',
			'supportText' => '',
			'allowBlank' => true
		]);
		
		$element->createMediaField([
			'name' => $this->pluginname . '_hintergrundbild',
			'fieldLabel' => 'Hintergrundbild',
			'supportText' => 'Bitte wählen Sie ein Bild aus der Media-Verwaltung.',
			'allowBlank' => true,
			'translatable' => true,
			'valueField' => 'path',
		]);
		
		$element->createComboBoxField([
			'fieldLabel' => 'Position',
			'name' => $this->pluginname . '_hintergrundposition',
			'supportText' => 'Sie können hier die Hintergrundposition festlegen.',
			'allowBlank' => false,
			'store' => 'Shopware.apps.nnwebEmotionHoverIcon.store.HintergrundPositionStore',
			'queryMode' => 'local',
			'displayField' => 'name',
			'valueField' => 'value',
			'defaultValue' => 'center center'
		]);
		
		$element->createTextField([
			'name' => $this->pluginname . '_hintergrundfarbe',
			'fieldLabel' => 'Hintergrundfarbe',
			'defaultValue' => '#000000',
			'supportText' => 'Geben Sie einen Hintergrund an. Zum Beispiel #000000 für schwarz.',
			'allowBlank' => true,
			'helpTitle' => 'Weitere Möglichkeiten',
			'helpText' => 'Probieren sie auch Werte aus wie "purple", "linear-gradient(#909,#606)", "rgba(0,0,0,0.8)" oder "transparent".'
		]);
		
		$element->createTextField([
			'name' => $this->pluginname . '_schriftfarbe',
			'fieldLabel' => 'Schriftfarbe',
			'defaultValue' => '#FFFFFF',
			'supportText' => 'Geben Sie eine Schriftfarbe im Hex-Format an an. Zum Beispiel #FFFFFF für weiß.',
			'allowBlank' => true
		]);
		
		// Überschrift
		$element->createDisplayField([
			'name' => 'ueberschrift',
			'defaultValue' => 'Überschrift',
			'supportText' => '',
			'allowBlank' => true
		]);
		
		$element->createCheckboxField([
			'name' => $this->pluginname . '_ueberschrift_anzeigen',
			'fieldLabel' => 'Anzeigen'
		]);
		
		$element->createComboBoxField([
			'fieldLabel' => 'HTML-Tag',
			'name' => $this->pluginname . '_ueberschrift_tag',
			'supportText' => 'Sie können hier den HTML-Tag, der für die Überschrift genutzt wird, eingeben.',
			'allowBlank' => false,
			'store' => 'Shopware.apps.nnwebEmotionHoverIcon.store.HeadlineTagStore',
			'queryMode' => 'local',
			'displayField' => 'name',
			'valueField' => 'value',
			'defaultValue' => 'h2'
		]);
		
		$element->createTextField([
			'name' => $this->pluginname . '_ueberschrift',
			'fieldLabel' => 'Überschrift',
			'defaultValue' => 'Überschrift',
			'supportText' => 'Sie können hier eine Überschrift eingeben.',
			'allowBlank' => true,
			'translatable' => true
		]);
		
		// Text
		$element->createDisplayField([
			'name' => 'text',
			'defaultValue' => 'Text',
			'supportText' => '',
			'allowBlank' => true
		]);
		
		$element->createCheckboxField([
			'name' => $this->pluginname . '_text_anzeigen',
			'fieldLabel' => 'Anzeigen'
		]);
		
		$element->createTextAreaField([
			'name' => $this->pluginname . '_text',
			'fieldLabel' => 'Text',
			'defaultValue' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.',
			'supportText' => 'Sie können hier einen Text eingeben',
			'allowBlank' => true,
			'translatable' => true
		]);
	}

	public function addLessFiles(\Enlight_Event_EventArgs $args) {
		$less = new \Shopware\Components\Theme\LessDefinition(array(), array(
				__DIR__ . '/Resources/views/frontend/_public/src/less/all.less'
		), __DIR__);
		
		return new ArrayCollection(array(
				$less
		));
	}

	public function extendsEmotionTemplates(\Enlight_Event_EventArgs $args) {
		$controller = $args->getSubject();
		$view = $controller->View();
		$view->addTemplateDir(__DIR__ . '/Resources/views/frontend/');
	}

	public function onPostDispatchBackendEmotion(\Enlight_Controller_ActionEventArgs $args) {
		$controller = $args->getSubject();
		$view = $controller->View();
		$view->addTemplateDir(__DIR__ . '/Resources/views/');
		$view->extendsTemplate('backend/emotion/nnweb_emotion_hover_icon/view/detail/elements/nnweb_emotion_hover_icon.js');
		$view->extendsTemplate('backend/emotion/nnweb_emotion_hover_icon/nnweb_emotion_hover_icon_store.js');
	}
}