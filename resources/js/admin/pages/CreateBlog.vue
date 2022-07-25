<template>
    <div class="content">
        <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
            <Breadcrumb class="mb-2">
                <Row>
                    <Col span="12">
                    <Breadcrumb>
                        <BreadcrumbItem to="/">
                            <Icon type="ios-home-outline"></Icon> Home
                        </BreadcrumbItem>
                        <BreadcrumbItem>
                            <Icon type="ios-albums"></Icon> Create Blog
                        </BreadcrumbItem>
                    </Breadcrumb>
                    </Col>
                    <Col span="12" class="text-right">
                    <Button type="default" size="small" @click="modal = true" v-if="isWritePermitted">
                        <Icon type="ios-add" />Add New
                    </Button>
                    </Col>
                </Row>
            </Breadcrumb>
            <div class="_overflow _table_div">

            </div>
        </div>
    </div>
</template>

<script>

</script>