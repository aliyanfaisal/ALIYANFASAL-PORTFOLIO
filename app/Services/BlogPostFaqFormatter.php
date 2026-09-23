<?php

namespace App\Services;

use DOMDocument;
use DOMElement;
use DOMNode;

class BlogPostFaqFormatter
{
    /**
     * Promote bolded questions under a "Frequently Asked Questions" heading to h3 subheadings
     * and collect the question/answer pairs found in that section.
     *
     * @return array{html: string, faqs: array<int, array{question: string, answer: string}>}
     */
    public function format(string $html): array
    {
        if (! preg_match('/<h2[^>]*>\s*(frequently asked questions|faqs?)\b/i', $html)) {
            return ['html' => $html, 'faqs' => []];
        }

        $previousLibxmlSetting = libxml_use_internal_errors(true);

        $document = new DOMDocument;
        $document->loadHTML(
            '<?xml encoding="utf-8"?><div>'.$html.'</div>',
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD,
        );

        libxml_clear_errors();
        libxml_use_internal_errors($previousLibxmlSetting);

        $root = $document->getElementsByTagName('div')->item(0);
        $faqs = [];
        $inFaqSection = false;

        foreach (iterator_to_array($root->childNodes) as $node) {
            if (! $node instanceof DOMElement) {
                continue;
            }

            if ($node->tagName === 'h2') {
                $inFaqSection = (bool) preg_match('/^(frequently asked questions|faqs?)\b/i', $this->text($node));

                continue;
            }

            if (! $inFaqSection) {
                continue;
            }

            if ($this->isBoldQuestion($node)) {
                $node = $this->promoteToHeading($document, $node);
            }

            if ($node->tagName === 'h3') {
                $faqs[] = ['question' => $this->text($node), 'answer' => ''];

                continue;
            }

            if ($faqs !== []) {
                $lastIndex = array_key_last($faqs);
                $faqs[$lastIndex]['answer'] = trim($faqs[$lastIndex]['answer'].' '.$this->text($node));
            }
        }

        $formattedHtml = '';
        foreach ($root->childNodes as $child) {
            $formattedHtml .= $document->saveHTML($child);
        }

        return [
            'html' => $formattedHtml,
            'faqs' => array_values(array_filter($faqs, fn (array $faq): bool => $faq['answer'] !== '')),
        ];
    }

    private function isBoldQuestion(DOMElement $node): bool
    {
        if ($node->tagName !== 'p') {
            return false;
        }

        $meaningfulChildren = array_filter(
            iterator_to_array($node->childNodes),
            fn (DOMNode $child): bool => ! ($child->nodeType === XML_TEXT_NODE && trim($child->textContent) === ''),
        );

        if (count($meaningfulChildren) !== 1) {
            return false;
        }

        $child = reset($meaningfulChildren);

        return $child instanceof DOMElement
            && $child->tagName === 'strong'
            && str_ends_with($this->text($child), '?');
    }

    private function promoteToHeading(DOMDocument $document, DOMElement $paragraph): DOMElement
    {
        $heading = $document->createElement('h3');
        $bold = $paragraph->getElementsByTagName('strong')->item(0);

        while ($bold->firstChild) {
            $heading->appendChild($bold->firstChild);
        }

        $paragraph->parentNode->replaceChild($heading, $paragraph);

        return $heading;
    }

    private function text(DOMNode $node): string
    {
        return trim(preg_replace('/\s+/u', ' ', $node->textContent));
    }
}
