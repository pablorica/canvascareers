<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use Log1x\AcfComposer\Builder;

/**
 * Grid Cell — places its inner blocks on the 6×6 InDesign page grid.
 * Lives only inside acf/page-text.
 */
class GridCell extends Block
{
    public $name = 'Grid Cell';

    public $description = 'Places content on the 6×6 magazine page grid.';

    public $category = 'design';

    public $icon = 'grid-view';

    public $keywords = ['grid', 'cell', 'magazine'];

    public $parent = ['acf/page-text'];

    public $mode = 'preview';

    public $supports = [
        'align' => false,
        'mode' => false,
        'anchor' => false,
        'jsx' => true,
    ];

    public function with(): array
    {
        $colStart = $this->intField('col_start', 1);
        $rowStart = $this->intField('row_start', 1);

        // Never let a cell run past the 6th column / row
        $colSpan = min($this->intField('col_span', 1), 7 - $colStart);
        $rowSpan = min($this->intField('row_span', 1), 7 - $rowStart);

        $align = get_field('align') ?: 'stretch';

        return [
            // Placement written straight onto the element, no CSS variables needed
            'cellStyle' => "grid-column: {$colStart} / span {$colSpan}; grid-row: {$rowStart} / span {$rowSpan};",
            'cellClasses' => implode(' ', array_filter([
                'grid-cell',
                $align !== 'stretch' ? "grid-cell--align-{$align}" : null,
                (int) get_field('text_columns') === 2 ? 'grid-cell--cols-2' : null,
                get_field('fill_media') ? 'grid-cell--fill' : null,
            ])),
            'cellAllowedBlocks' => [
                'core/paragraph',
                'core/heading',
                'core/image',
                'core/video',
                'core/embed',
                'core/list',
                'core/quote',
                'core/spacer',
            ],
        ];
    }

    public function fields(): array
    {
        $number = fn (string $label) => [
            'label' => $label,
            'min' => 1,
            'max' => 6,
            'step' => 1,
            'default_value' => 1,
            'wrapper' => ['width' => 25],
        ];

        $fields = Builder::make('grid_cell');

        $fields
            ->addNumber('col_start', $number('Column start'))
            ->addNumber('col_span', $number('Column span'))
            ->addNumber('row_start', $number('Row start'))
            ->addNumber('row_span', $number('Row span'))
            ->addSelect('align', [
                'label' => 'Vertical alignment',
                'choices' => [
                    'stretch' => 'Fill cell',
                    'start' => 'Top',
                    'center' => 'Middle',
                    'end' => 'Bottom',
                ],
                'default_value' => 'stretch',
                'wrapper' => ['width' => 50],
            ])
            ->addSelect('text_columns', [
                'label' => 'Text columns',
                'choices' => ['1' => '1', '2' => '2'],
                'default_value' => '1',
                'wrapper' => ['width' => 50],
            ])
            ->addTrueFalse('fill_media', [
                'label' => 'Crop media to fill the cell',
                'ui' => 1,
                'wrapper' => ['width' => 100],
            ]);

        return $fields->build();
    }

    private function intField(string $name, int $default): int
    {
        $value = (int) (get_field($name) ?: $default);

        return max(1, min(6, $value));
    }
}