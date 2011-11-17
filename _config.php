<?php
DataObject::add_extension('ImageCarouselItem', 'LinkFieldsDecorator');
SortableDataObject::add_sortable_classes(array('Banner', 'ImageCarouselItem'));
