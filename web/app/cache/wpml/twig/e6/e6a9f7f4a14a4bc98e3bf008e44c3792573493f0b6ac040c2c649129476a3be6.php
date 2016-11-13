<?php

/* menus-wrap.twig */
class __TwigTemplate_0d3b8104c631d1b3df46bf85c18ecebc6d59cbb35747e494f58e88b1e318843f extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<div class=\"wrap\">
    <h1>";
        // line 2
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "title", array()), "html", null, true);
        echo "</h1>
    <nav class=\"wcml-tabs wpml-tabs\">
        <a class=\"nav-tab ";
        // line 4
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["menu"]) ? $context["menu"] : null), "products", array()), "active", array()), "html", null, true);
        echo "\" href=\"";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["menu"]) ? $context["menu"] : null), "products", array()), "url", array()), "html", null, true);
        echo "\">";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["menu"]) ? $context["menu"] : null), "products", array()), "title", array()), "html", null, true);
        echo "</a>
        ";
        // line 5
        if ((isset($context["can_operate_options"]) ? $context["can_operate_options"] : null)) {
            // line 6
            echo "            ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["menu"]) ? $context["menu"] : null), "taxonomies", array()));
            foreach ($context['_seq'] as $context["key"] => $context["taxonomy"]) {
                // line 7
                echo "            <a class=\"js-tax-tab-";
                echo twig_escape_filter($this->env, $context["key"], "html", null, true);
                echo " nav-tab ";
                echo twig_escape_filter($this->env, $this->getAttribute($context["taxonomy"], "active", array()), "html", null, true);
                echo "\" href=\"";
                echo twig_escape_filter($this->env, $this->getAttribute($context["taxonomy"], "url", array()), "html", null, true);
                echo "\" title=\"";
                echo twig_escape_filter($this->env, $this->getAttribute($context["taxonomy"], "title", array()), "html", null, true);
                echo "\">
            ";
                // line 8
                echo twig_escape_filter($this->env, $this->getAttribute($context["taxonomy"], "name", array()), "html", null, true);
                echo "
            ";
                // line 9
                if (($this->getAttribute($context["taxonomy"], "translated", array()) == false)) {
                    echo "<i class=\"otgs-ico-warning\"></i>";
                }
                // line 10
                echo "            </a>
            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['key'], $context['taxonomy'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 12
            echo "            <a class=\"nav-tab tax-product-attributes ";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["menu"]) ? $context["menu"] : null), "attributes", array()), "active", array()), "html", null, true);
            echo "\" href=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["menu"]) ? $context["menu"] : null), "attributes", array()), "url", array()), "html", null, true);
            echo "\">
                ";
            // line 13
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["menu"]) ? $context["menu"] : null), "attributes", array()), "name", array()), "html", null, true);
            echo "
                ";
            // line 14
            if (($this->getAttribute($this->getAttribute((isset($context["menu"]) ? $context["menu"] : null), "attributes", array()), "translated", array()) == false)) {
                echo "<i class=\"otgs-ico-warning\"></i>";
            }
            // line 15
            echo "            </a>

            <a class=\"js-tax-tab-product_shipping_class nav-tab ";
            // line 17
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["menu"]) ? $context["menu"] : null), "shipping_classes", array()), "active", array()), "html", null, true);
            echo "\" href=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["menu"]) ? $context["menu"] : null), "shipping_classes", array()), "url", array()), "html", null, true);
            echo "\"
               title=\"";
            // line 18
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["menu"]) ? $context["menu"] : null), "shipping_classes", array()), "title", array()), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["menu"]) ? $context["menu"] : null), "shipping_classes", array()), "name", array()), "html", null, true);
            echo "
               ";
            // line 19
            if (($this->getAttribute($this->getAttribute((isset($context["menu"]) ? $context["menu"] : null), "shipping_classes", array()), "translated", array()) == false)) {
                echo "<i class=\"otgs-ico-warning\"></i>";
            }
            // line 20
            echo "            </a>
        ";
        }
        // line 22
        echo "
        ";
        // line 23
        if ((isset($context["can_manage_options"]) ? $context["can_manage_options"] : null)) {
            // line 24
            echo "            <a class=\"nav-tab ";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["menu"]) ? $context["menu"] : null), "settings", array()), "active", array()), "html", null, true);
            echo "\" href=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["menu"]) ? $context["menu"] : null), "settings", array()), "url", array()), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["menu"]) ? $context["menu"] : null), "settings", array()), "name", array()), "html", null, true);
            echo "</a>
            <a class=\"nav-tab ";
            // line 25
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["menu"]) ? $context["menu"] : null), "multi_currency", array()), "active", array()), "html", null, true);
            echo "\" href=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["menu"]) ? $context["menu"] : null), "multi_currency", array()), "url", array()), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["menu"]) ? $context["menu"] : null), "multi_currency", array()), "name", array()), "html", null, true);
            echo "</a>
        ";
        }
        // line 27
        echo "        ";
        if ((isset($context["can_operate_options"]) ? $context["can_operate_options"] : null)) {
            // line 28
            echo "            <a class=\"nav-tab ";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["menu"]) ? $context["menu"] : null), "slugs", array()), "active", array()), "html", null, true);
            echo "\" href=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["menu"]) ? $context["menu"] : null), "slugs", array()), "url", array()), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["menu"]) ? $context["menu"] : null), "slugs", array()), "name", array()), "html", null, true);
            echo "</a>
        ";
        }
        // line 30
        echo "        ";
        if ((isset($context["can_manage_options"]) ? $context["can_manage_options"] : null)) {
            // line 31
            echo "            <a class=\"nav-tab ";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["menu"]) ? $context["menu"] : null), "status", array()), "active", array()), "html", null, true);
            echo "\" href=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["menu"]) ? $context["menu"] : null), "status", array()), "url", array()), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["menu"]) ? $context["menu"] : null), "status", array()), "name", array()), "html", null, true);
            echo "</a>
            ";
            // line 32
            if ($this->getAttribute($this->getAttribute((isset($context["menu"]) ? $context["menu"] : null), "troubleshooting", array()), "active", array())) {
                // line 33
                echo "                <a class=\"nav-tab troubleshooting ";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["menu"]) ? $context["menu"] : null), "troubleshooting", array()), "active", array()), "html", null, true);
                echo "\" href=\"";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["menu"]) ? $context["menu"] : null), "troubleshooting", array()), "url", array()), "html", null, true);
                echo "\">";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["menu"]) ? $context["menu"] : null), "troubleshooting", array()), "name", array()), "html", null, true);
                echo "</a>
            ";
            }
            // line 35
            echo "        ";
        }
        // line 36
        echo "    </nav>

    <div class=\"wcml-wrap\">
    ";
        // line 39
        echo (isset($context["content"]) ? $context["content"] : null);
        echo "
    </div>

    <div class=\"wcml-wrap wcml-notice otgs-is-dismissible\">
        <p>";
        // line 43
        echo $this->getAttribute((isset($context["rate"]) ? $context["rate"] : null), "message", array());
        echo "</p>
        <button class=\"notice-dismiss hide-rate-block\" data-setting=\"rate-block\">
                <span class=\"screen-reader-text\">";
        // line 45
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["rate"]) ? $context["rate"] : null), "hide_text", array()), "html", null, true);
        echo "</span>
        </button>
        ";
        // line 47
        echo $this->getAttribute((isset($context["rate"]) ? $context["rate"] : null), "nonce", array());
        echo "
    </div>

</div>";
    }

    public function getTemplateName()
    {
        return "menus-wrap.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  192 => 47,  187 => 45,  182 => 43,  175 => 39,  170 => 36,  167 => 35,  157 => 33,  155 => 32,  146 => 31,  143 => 30,  133 => 28,  130 => 27,  121 => 25,  112 => 24,  110 => 23,  107 => 22,  103 => 20,  99 => 19,  93 => 18,  87 => 17,  83 => 15,  79 => 14,  75 => 13,  68 => 12,  61 => 10,  57 => 9,  53 => 8,  42 => 7,  37 => 6,  35 => 5,  27 => 4,  22 => 2,  19 => 1,);
    }
}
/* <div class="wrap">*/
/*     <h1>{{ strings.title }}</h1>*/
/*     <nav class="wcml-tabs wpml-tabs">*/
/*         <a class="nav-tab {{ menu.products.active }}" href="{{ menu.products.url }}">{{ menu.products.title }}</a>*/
/*         {%  if can_operate_options %}*/
/*             {% for key, taxonomy in menu.taxonomies %}*/
/*             <a class="js-tax-tab-{{ key }} nav-tab {{ taxonomy.active }}" href="{{ taxonomy.url }}" title="{{ taxonomy.title }}">*/
/*             {{ taxonomy.name }}*/
/*             {% if taxonomy.translated == false %}<i class="otgs-ico-warning"></i>{% endif %}*/
/*             </a>*/
/*             {% endfor %}*/
/*             <a class="nav-tab tax-product-attributes {{ menu.attributes.active }}" href="{{ menu.attributes.url }}">*/
/*                 {{ menu.attributes.name }}*/
/*                 {% if menu.attributes.translated == false %}<i class="otgs-ico-warning"></i>{% endif %}*/
/*             </a>*/
/* */
/*             <a class="js-tax-tab-product_shipping_class nav-tab {{ menu.shipping_classes.active }}" href="{{ menu.shipping_classes.url }}"*/
/*                title="{{ menu.shipping_classes.title }}">{{ menu.shipping_classes.name }}*/
/*                {% if menu.shipping_classes.translated == false %}<i class="otgs-ico-warning"></i>{% endif %}*/
/*             </a>*/
/*         {% endif %}*/
/* */
/*         {% if can_manage_options %}*/
/*             <a class="nav-tab {{ menu.settings.active }}" href="{{ menu.settings.url }}">{{ menu.settings.name }}</a>*/
/*             <a class="nav-tab {{ menu.multi_currency.active }}" href="{{ menu.multi_currency.url }}">{{ menu.multi_currency.name }}</a>*/
/*         {% endif %}*/
/*         {%  if can_operate_options %}*/
/*             <a class="nav-tab {{ menu.slugs.active }}" href="{{ menu.slugs.url }}">{{ menu.slugs.name }}</a>*/
/*         {% endif %}*/
/*         {% if can_manage_options %}*/
/*             <a class="nav-tab {{ menu.status.active }}" href="{{ menu.status.url }}">{{ menu.status.name }}</a>*/
/*             {% if menu.troubleshooting.active %}*/
/*                 <a class="nav-tab troubleshooting {{ menu.troubleshooting.active }}" href="{{ menu.troubleshooting.url }}">{{ menu.troubleshooting.name }}</a>*/
/*             {% endif %}*/
/*         {% endif %}*/
/*     </nav>*/
/* */
/*     <div class="wcml-wrap">*/
/*     {{ content|raw }}*/
/*     </div>*/
/* */
/*     <div class="wcml-wrap wcml-notice otgs-is-dismissible">*/
/*         <p>{{ rate.message|raw }}</p>*/
/*         <button class="notice-dismiss hide-rate-block" data-setting="rate-block">*/
/*                 <span class="screen-reader-text">{{ rate.hide_text }}</span>*/
/*         </button>*/
/*         {{ rate.nonce|raw }}*/
/*     </div>*/
/* */
/* </div>*/
