# Dcat Admin 图片预览扩展

#### 安装
```
composer require abovesky/dcat-lightbox
```

>具体安装方法请参考官方文档

#### 使用方法
```$xslt
// 数据表格中使用
$grid->column('images')->lightbox();

//设置服务器和宽高
$grid->column('images')->lightbox('http://xxx.com', 100, 100);

// 数据详情中使用
$show->field('images')->lightbox();
```

>当字段为数组时为多图浏览

#### License

Licensed under The [MIT License (MIT). ](https://github.com/dcat-admin-extensions/lightbox/blob/master/LICENSE)


