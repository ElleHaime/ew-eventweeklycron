<!DOCTYPE html>
<html>
<head>
    <title>{% block title %}{% endblock %}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {%- block head -%}

    {%- endblock -%}

    {{ assets.outputJs() }}
    {{ assets.outputCss() }}
</head>
<style type="text/css">
    .x-menu-item img.preview-right, .preview-right {
        background-image: url({{modulePath}}/images/preview-right.gif);
    }
    .x-menu-item img.preview-bottom, .preview-bottom {
        background-image: url({{modulePath}}/images/preview-bottom.gif);
    }
    .x-menu-item img.preview-hide, .preview-hide {
        background-image: url({{modulePath}}/images/preview-hide.gif);
    }

    #reading-menu .x-menu-item-checked {
        border: 1px dotted #a3bae9 !important;
        background: #DFE8F6;
        padding: 0;
        margin: 0;
    }
</style>
<script type="text/javascript">
    function hasOption (name) {
        return window.location.search.indexOf(name) >= 0;
    }
    function formatDate(value){
        return value ? Ext.Date.dateFormat(value, 'Y-m-d') : '';
    }
    Ext.Loader.setConfig({enabled: true});
    Ext.Loader.setPath('Ext.ux', '../ux');

  {% include "layouts/config.volt" %}
  {% include "layouts/require.volt" %}

    {%- block content -%}
    {%- endblock -%}

Ext.onReady(function() {
    Ext.tip.QuickTipManager.init();
{% include "layouts/application.volt" %}
});
</script>
<body>
</body>
</html>