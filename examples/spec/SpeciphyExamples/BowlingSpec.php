<?php
namespace Speciphy\DSL;

use \SpeciphyExamples\Bowling;

return describe('Bowling',
    context('全てガーターのとき',
        subject(function () {
            $bowling = new Bowling;
            for ($i = 1; $i <= 20; $i++) {
                $bowling->hit(0);
            }
            return $bowling;
        }),

        it('スコアは 0 になる', function ($bowling) {
            $bowling->score->should->equal(0);
        })
    )
);
