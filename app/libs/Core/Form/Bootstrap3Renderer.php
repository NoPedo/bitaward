<?php
namespace App\Core\Forms;

use Nette;
use Nette\Application\UI\ITemplateFactory;
use Nette\Forms\Controls;
use Nette\Forms\Rendering\DefaultFormRenderer;
use Nette\Utils\Html;

/**
 * @author David Matejka
 */
class Bootstrap3Renderer extends DefaultFormRenderer
{

	/** @var bool */
	protected $initialized = FALSE;

	public $labelWidth = 4;

	/** @var ITemplateFactory */
	private $templateFactory;


	public function __construct(ITemplateFactory $templateFactory)
	{
		$this->templateFactory = $templateFactory;
	}


	public function initialize(Nette\Forms\Form $form)
	{
		if ($this->initialized) {
			return;
		}
		$this->wrappers['controls']['container'] = NULL;
		$this->wrappers['pair']['container'] = 'div class=form-group';
		$this->wrappers['pair']['.error'] = 'has-error';
		$this->wrappers['control']['description'] = 'span class=help-block';
		$this->wrappers['control']['errorcontainer'] = 'span class=help-block';

		$formEl = $form->getElementPrototype();
		$classes = self::getClasses($formEl);
		if (!$classes || stripos($classes, 'form-') === FALSE || stripos($classes, 'form-horizontal') !== FALSE) {
			$mode = 'horizontal';
			if (($pos = strpos($classes, 'form-width-')) !== FALSE) {
				$this->labelWidth = (int) substr($classes, $pos + strlen('form-width') + 1, 2);
			}
			$formEl->addClass('form-horizontal');
			$this->wrappers['control']['container'] = 'div class=col-sm-' . (12 - $this->labelWidth);
			$this->wrappers['label']['container'] = 'div class="col-sm-' . $this->labelWidth . ' control-label"';
		} elseif ($classes && stripos($classes, 'form-inline') !== FALSE) {
			$mode = 'inline';
			$formEl->addClass('form-inline');
			$this->wrappers['control']['container'] = NULL;
			$this->wrappers['label']['container'] = NULL;
		} else {
			$mode = 'basic';
			$this->wrappers['control']['container'] = 'div';
			$this->wrappers['label']['container'] = 'div class=control-label';
		}

		foreach ($form->getControls() as $control) {
			if ($control instanceof Controls\Button) {
				$class = $control->getControlPrototype()->class;
				if (is_array($class)) {
					$class = implode(" ", $class);
				}
				$class = (empty($usedPrimary) ? 'btn btn-primary' : 'btn btn-default') . " " . $class;
				$control->getControlPrototype()->class = $class;
				$usedPrimary = TRUE;

			} elseif ($control instanceof Controls\TextBase
				|| $control instanceof Controls\SelectBox
				|| $control instanceof Controls\MultiSelectBox
				|| $control instanceof DateTimeInput
				|| $control instanceof Controls\UploadControl
			) {
				$class = $control->getControlPrototype()->class;

				if (!is_array($class)) {
					$class = explode(" ", $class);
				}
				$class[] = 'form-control';
				$control->getControlPrototype()->class = $class;

			} elseif ($control instanceof Controls\Checkbox || $control instanceof Controls\CheckboxList || $control instanceof Controls\RadioList) {
				$control->getSeparatorPrototype()->setName('div')->class($control->getControlPrototype()->type);
			}

			if ($mode == 'inline') {
				//$control->getLabelPrototype()->class('sr-only');
			}
		}
		$this->initialized = TRUE;
	}


	/**
	 * Renders form body.
	 *
	 * @return string
	 */
	public function renderBody()
	{
		$s = $remains = '';

		$defaultContainer = $this->getWrapper('group container');
		$translator = $this->form->getTranslator();

		foreach ($this->form->getGroups() as $group) {
			if (!$group->getControls() || !$group->getOption('visual')) {
				continue;
			}
			if ($templateFile = $group->getOption('template')) {
				$template = $this->templateFactory->createTemplate();
				$template->setFile($templateFile);
				$template->form = $this->form;
				$template->_form = $this->form;
				$template->group = $group;
				$s .= (string) $template;

			}

			$container = $group->getOption('container', $defaultContainer);
			$container = $container instanceof Html ? clone $container : Html::el($container);

			$id = $group->getOption('id');
			if ($id) {
				$container->id = $id;
			}

			$s .= "\n" . $container->startTag();

			$text = $group->getOption('label');
			if ($text instanceof Html) {
				$s .= $this->getWrapper('group label')->add($text);

			} elseif (is_string($text)) {
				if ($translator !== NULL) {
					$text = $translator->translate($text);
				}
				$s .= "\n" . $this->getWrapper('group label')->setText($text) . "\n";
			}

			$text = $group->getOption('description');
			if ($text instanceof Html) {
				$s .= $text;

			} elseif (is_string($text)) {
				if ($translator !== NULL) {
					$text = $translator->translate($text);
				}
				$s .= $this->getWrapper('group description')->setText($text) . "\n";
			}

			$s .= $this->renderControls($group);

			$remains = $container->endTag() . "\n" . $remains;
			if (!$group->getOption('embedNext')) {
				$s .= $remains;
				$remains = '';
			}
		}

		$s .= $remains . $this->renderControls($this->form);

		$container = $this->getWrapper('form container');
		$container->setHtml($s);

		return $container->render(0);
	}


	public function render(Nette\Forms\Form $form, $mode = NULL)
	{
		if ($this->form !== $form) {
			$this->initialized = FALSE;
		}
		if (!$this->initialized) {
			$this->initialize($form);
		}
		if ($mode === 'initialize') {
			return;
		}
		if ($mode instanceof Nette\Forms\IControl) {
			return $this->renderPair($mode);
		}

		return parent::render($form, $mode);
	}


	/**
	 * @param Html $el
	 * @return bool
	 */
	private static function getClasses(Html $el)
	{
		if (is_array($el->class)) {
			$classes = array_filter(array_merge(array_keys($el->class), $el->class), 'is_string');

			return implode(' ', $classes);
		}

		return $el->class;
	}
}
