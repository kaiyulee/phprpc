<?php
namespace Book;

use Book\Models\BookModel;
use Helper\Fn;

class Handler implements BookIf
{
    public function getBookInfo($id)
    {
        var_dump($id);
        if (!empty($id)) {
            $info = [
                'name' => '钢铁是怎样炼成的',
                'price' => 0.88,
                'author' => '前苏联奥斯特洛夫斯基',
            ];
        } else {
            $info = [];
        }

        $model = new BookModel();
        $t = $model->test();
        var_dump($t);

        $model->test2();

        Fn::logit($t, ['100' => 101]);
        Fn::logit('hello debug', ['author' => 'qiang.zou']);
        Fn::logit('hello info', ['author' => 'qiang.zou'], 200);
        Fn::logit('hello info', ['author' => 'qiang.zou'], 250, 'my_logger');

        return new BookInfo($info);
    }
}
