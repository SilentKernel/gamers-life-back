<?php

namespace Silentkernel\CommentBundle\Parser;

use Knp\Bundle\MarkdownBundle\Parser\MarkdownParser;

/**
 * Medium featured Markdown Parser
 */
class Comment extends MarkdownParser
{
    /**
     * @var array Enabled features
     */
    protected $features = array(
        'header' => true,
        'list' => true,
        'horizontal_rule' => true,
        'table' => true,
        'foot_note' => true,
        'fenced_code_block' => true,
        'abbreviation' => true,
        'definition_list' => true,
        'inline_link' => true, // [link text](url "optional title")
        'reference_link' => true, // [link text] [id]
        'shortcut_link' => false, // [link text]
        'images' => false,
        'block_quote' => false,
        'code_block' => false,
        'html_block' => false,
        'auto_link' => true,
        'auto_mailto' => false,
        'entities' => false,
        'no_html' => true,
    );
}
