<?php
defined('_JEXEC') or die;

// Create View adapter for Joomla! 1.5 or 1.6. "protected" visibility level 
// of the item/article property prevents from creating view factory.
// The ArtxContentArticleView16 and ArtxContentArticleView15 classes are defined
// in ../../../functions.php file and contain version-specific queries and formatting.
if ($GLOBALS['version']->RELEASE == '1.6') {
 $view = new ArtxContentArticleView16($this, $this->item, $this->item->params);
 JHtml::addIncludePath(JPATH_COMPONENT . DS . 'helpers');
} else {
 $view = new ArtxContentArticleView15($this, $this->item, $this->item->params);
}


if ($this->item->state == 0)
 echo '<div class="system-unpublished">';


$article = $view->getArticleViewParameters();
if ($view->titleVisible) {
 $article['header-text'] = $this->escape($view->title);
 if (strlen($view->titleLink))
  $article['header-link'] = $view->titleLink;
}
// Change the order of "if" statements to change the order of article metadata header items.
if ($view->params->get('show_create_date'))
 $article['metadata-header-icons'][] = $view->renderCreateDateInfo();
if ($view->params->get('show_modify_date'))
 $article['metadata-header-icons'][] = $view->renderModifyDateInfo();
if ($view->params->get('show_publish_date'))
 $article['metadata-header-icons'][] = $view->renderPublishDateInfo();
if ($view->params->get('show_author') && !empty($view->item->author))
 $article['metadata-header-icons'][] = $view->renderAuthorInfo();
if (!$view->print && $view->pdf && $view->params->get('show_pdf_icon'))
 $article['metadata-header-icons'][] = $view->renderPdfIcon();
if (!$view->print && $view->params->get('show_print_icon'))
 $article['metadata-header-icons'][] = $view->renderPrintPopupIcon();
if ($view->print)
 $article['metadata-header-icons'][] = $view->renderPrintScreenIcon();
if (!$view->print && $view->params->get('show_email_icon'))
  $article['metadata-header-icons'][] = $view->renderEmailIcon();
if (!$view->print && $view->canEdit)
  $article['metadata-header-icons'][] = $view->renderEditIcon();
if ($view->hits && $view->params->get('show_hits'))
 $article['metadata-header-icons'][] = $view->renderHitsInfo();
// Build article content
$content = '';
if (!$view->params->get('show_intro'))
 $content .= $view->item->event->afterDisplayTitle;
$content .= $view->item->event->beforeDisplayContent;
if (isset ($view->item->toc))
 $content .= $view->item->toc;
$content .= "<div class=\"art-article\">" . $view->item->text . "</div>";
if ($view->params->get('show_readmore') && $view->item->readmore) {
 $content .= '<p>' . artxLinkButton(array('classes' => array('a' => 'readon'), 'link' => $view->item->readmore_link,
  'content' => str_replace(' ', '&nbsp;', $view->item->readmore_register ? JText::_('Register to read more...')
   : ($view->params->get('readmore') ? $view->params->get('readmore') : JText::sprintf('Read more...'))))) . '</p>';
}
$content .= "<span class=\"article_separator\">&nbsp;</span>";
$content .= $view->item->event->afterDisplayContent;
$article['content'] = $content;
// Change the order of "if" statements to change the order of article metadata footer items.
if ($view->parentCategoryVisible || $view->categoryVisible)
  $article['metadata-footer-icons'][] = JHTML::_('image.site', 'postcategoryicon.png', null, null, null, JText::_("postcategoryicon"), array('width' => '18', 'height' => '18')) . $view->renderCategories();;
// Render article
echo $view->renderArticle($article);


if ($this->item->state == 0)
 echo '</div>';
