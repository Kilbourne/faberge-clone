<?php

/* store-urls.twig */
class __TwigTemplate_9aee63bb48b2aeaff3aac2ce506fdfe52279a9d005667da5df26c9c2ffa5d49c extends Twig_Template
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
        echo "<div>
    <p>";
        // line 2
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "notice", array()), "html", null, true);
        echo "</p>
    <p>";
        // line 3
        echo $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "notice_defaults", array());
        echo "</p>
</div>
<table class=\"widefat wpml-list-table wp-list-table striped\" cellspacing=\"0\">
    <thead>
        <tr>
            <th scope=\"col\">";
        // line 8
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "slug_type", array()), "html", null, true);
        echo "</th>
            <th scope=\"col\" id=\"date\" class=\"wpml-col-url\">
                ";
        // line 10
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "orig_slug", array()), "html", null, true);
        echo "
            </th>
            <th scope=\"col\" class=\"wpml-col-languages\">
                ";
        // line 13
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["data"]) ? $context["data"] : null), "flags", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["language"]) {
            // line 14
            echo "                    <span title=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($context["language"], "name", array()));
            echo "\">
\t\t\t\t\t\t\t<img src=\"";
            // line 15
            echo twig_escape_filter($this->env, $this->getAttribute($context["language"], "flag_url", array()), "html", null, true);
            echo "\"  alt=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($context["language"], "name", array()));
            echo "\"/>
\t\t\t\t\t\t</span>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['language'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 18
        echo "            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <strong>
                    ";
        // line 25
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "shop", array()), "html", null, true);
        echo "
                </strong>
            </td>

            <td class=\"wpml-col-url\">
                <img src=\"";
        // line 30
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["shop_base"]) ? $context["shop_base"] : null), "flag", array()), "html", null, true);
        echo "\" />
                <strong>";
        // line 31
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["shop_base"]) ? $context["shop_base"] : null), "orig_value", array()), "html", null, true);
        echo "</strong>
            </td>

            <td class=\"wpml-col-languages\">
                ";
        // line 35
        echo $this->getAttribute((isset($context["shop_base"]) ? $context["shop_base"] : null), "statuses", array());
        echo "
            </td>

        </tr>
        <tr>
            <td>
                <strong>
                    ";
        // line 42
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "product", array()), "html", null, true);
        echo "
                </strong>
            </td>

            <td class=\"wpml-col-url\">
                <img src=\"";
        // line 47
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["product_base"]) ? $context["product_base"] : null), "flag", array()), "html", null, true);
        echo "\" />
                <strong>";
        // line 48
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["product_base"]) ? $context["product_base"] : null), "orig_value", array()), "html", null, true);
        echo "</strong>
            </td>

            <td class=\"wpml-col-languages\">
                ";
        // line 52
        echo $this->getAttribute((isset($context["product_base"]) ? $context["product_base"] : null), "statuses", array());
        echo "
            </td>

        </tr>
        <tr>
            <td>
                <strong>
                    ";
        // line 59
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "category", array()), "html", null, true);
        echo "
                </strong>
            </td>

            <td class=\"wpml-col-url\">
                <img src=\"";
        // line 64
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["cat_base"]) ? $context["cat_base"] : null), "flag", array()), "html", null, true);
        echo "\" />
                <strong>";
        // line 65
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["cat_base"]) ? $context["cat_base"] : null), "orig_value", array()), "html", null, true);
        echo "</strong>
            </td>

            <td class=\"wpml-col-languages\">
                ";
        // line 69
        echo $this->getAttribute((isset($context["cat_base"]) ? $context["cat_base"] : null), "statuses", array());
        echo "
            </td>

        </tr>
        <tr>
            <td>
                <strong>
                    ";
        // line 76
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "tag", array()), "html", null, true);
        echo "
                </strong>
            </td>

            <td class=\"wpml-col-url\">
                <img src=\"";
        // line 81
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["tag_base"]) ? $context["tag_base"] : null), "flag", array()), "html", null, true);
        echo "\" />
                <strong>";
        // line 82
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["tag_base"]) ? $context["tag_base"] : null), "orig_value", array()), "html", null, true);
        echo "</strong>
            </td>

            <td class=\"wpml-col-languages\">
                ";
        // line 86
        echo $this->getAttribute((isset($context["tag_base"]) ? $context["tag_base"] : null), "statuses", array());
        echo "
            </td>

        </tr>
        <tr>
            <td>
                <strong>
                    ";
        // line 93
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "attr", array()), "html", null, true);
        echo "
                </strong>
            </td>

            <td class=\"wpml-col-url\">
                <img src=\"";
        // line 98
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["attr_base"]) ? $context["attr_base"] : null), "flag", array()), "html", null, true);
        echo "\" />
                <strong>";
        // line 99
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["attr_base"]) ? $context["attr_base"] : null), "orig_value", array()), "html", null, true);
        echo "</strong>
            </td>

            <td class=\"wpml-col-languages\">
                ";
        // line 103
        echo $this->getAttribute((isset($context["attr_base"]) ? $context["attr_base"] : null), "statuses", array());
        echo "
            </td>
        </tr>
        ";
        // line 106
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["endpoints_base"]) ? $context["endpoints_base"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["endpoint"]) {
            // line 107
            echo "            <tr>
                <td>
                    <strong>
                        ";
            // line 110
            echo twig_escape_filter($this->env, sprintf($this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "endpoint", array()), $this->getAttribute($context["endpoint"], "key", array())), "html", null, true);
            echo "
                    </strong>
                </td>

                <td class=\"wpml-col-url\">
                    <img src=\"";
            // line 115
            echo twig_escape_filter($this->env, $this->getAttribute($context["endpoint"], "flag", array()), "html", null, true);
            echo "\" />
                    <strong>";
            // line 116
            echo twig_escape_filter($this->env, $this->getAttribute($context["endpoint"], "orig_value", array()), "html", null, true);
            echo "</strong>
                </td>

                <td class=\"wpml-col-languages\">
                    ";
            // line 120
            echo $this->getAttribute($context["endpoint"], "statuses", array());
            echo "
                </td>
            </tr>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['endpoint'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 124
        echo "    </tbody>
</table>


";
        // line 128
        echo $this->getAttribute((isset($context["nonces"]) ? $context["nonces"] : null), "edit_base", array());
        echo "
";
        // line 129
        echo $this->getAttribute((isset($context["nonces"]) ? $context["nonces"] : null), "update_base", array());
    }

    public function getTemplateName()
    {
        return "store-urls.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  263 => 129,  259 => 128,  253 => 124,  243 => 120,  236 => 116,  232 => 115,  224 => 110,  219 => 107,  215 => 106,  209 => 103,  202 => 99,  198 => 98,  190 => 93,  180 => 86,  173 => 82,  169 => 81,  161 => 76,  151 => 69,  144 => 65,  140 => 64,  132 => 59,  122 => 52,  115 => 48,  111 => 47,  103 => 42,  93 => 35,  86 => 31,  82 => 30,  74 => 25,  65 => 18,  54 => 15,  49 => 14,  45 => 13,  39 => 10,  34 => 8,  26 => 3,  22 => 2,  19 => 1,);
    }
}
/* <div>*/
/*     <p>{{ strings.notice }}</p>*/
/*     <p>{{ strings.notice_defaults|raw }}</p>*/
/* </div>*/
/* <table class="widefat wpml-list-table wp-list-table striped" cellspacing="0">*/
/*     <thead>*/
/*         <tr>*/
/*             <th scope="col">{{ strings.slug_type }}</th>*/
/*             <th scope="col" id="date" class="wpml-col-url">*/
/*                 {{ strings.orig_slug }}*/
/*             </th>*/
/*             <th scope="col" class="wpml-col-languages">*/
/*                 {% for language in data.flags %}*/
/*                     <span title="{{ language.name|e }}">*/
/* 							<img src="{{ language.flag_url }}"  alt="{{ language.name|e }}"/>*/
/* 						</span>*/
/*                 {% endfor %}*/
/*             </th>*/
/*         </tr>*/
/*     </thead>*/
/*     <tbody>*/
/*         <tr>*/
/*             <td>*/
/*                 <strong>*/
/*                     {{ strings.shop }}*/
/*                 </strong>*/
/*             </td>*/
/* */
/*             <td class="wpml-col-url">*/
/*                 <img src="{{ shop_base.flag }}" />*/
/*                 <strong>{{ shop_base.orig_value }}</strong>*/
/*             </td>*/
/* */
/*             <td class="wpml-col-languages">*/
/*                 {{ shop_base.statuses|raw  }}*/
/*             </td>*/
/* */
/*         </tr>*/
/*         <tr>*/
/*             <td>*/
/*                 <strong>*/
/*                     {{ strings.product }}*/
/*                 </strong>*/
/*             </td>*/
/* */
/*             <td class="wpml-col-url">*/
/*                 <img src="{{ product_base.flag }}" />*/
/*                 <strong>{{ product_base.orig_value }}</strong>*/
/*             </td>*/
/* */
/*             <td class="wpml-col-languages">*/
/*                 {{ product_base.statuses|raw }}*/
/*             </td>*/
/* */
/*         </tr>*/
/*         <tr>*/
/*             <td>*/
/*                 <strong>*/
/*                     {{ strings.category }}*/
/*                 </strong>*/
/*             </td>*/
/* */
/*             <td class="wpml-col-url">*/
/*                 <img src="{{ cat_base.flag }}" />*/
/*                 <strong>{{ cat_base.orig_value }}</strong>*/
/*             </td>*/
/* */
/*             <td class="wpml-col-languages">*/
/*                 {{ cat_base.statuses|raw }}*/
/*             </td>*/
/* */
/*         </tr>*/
/*         <tr>*/
/*             <td>*/
/*                 <strong>*/
/*                     {{ strings.tag }}*/
/*                 </strong>*/
/*             </td>*/
/* */
/*             <td class="wpml-col-url">*/
/*                 <img src="{{ tag_base.flag }}" />*/
/*                 <strong>{{ tag_base.orig_value }}</strong>*/
/*             </td>*/
/* */
/*             <td class="wpml-col-languages">*/
/*                 {{ tag_base.statuses|raw }}*/
/*             </td>*/
/* */
/*         </tr>*/
/*         <tr>*/
/*             <td>*/
/*                 <strong>*/
/*                     {{ strings.attr }}*/
/*                 </strong>*/
/*             </td>*/
/* */
/*             <td class="wpml-col-url">*/
/*                 <img src="{{ attr_base.flag }}" />*/
/*                 <strong>{{ attr_base.orig_value }}</strong>*/
/*             </td>*/
/* */
/*             <td class="wpml-col-languages">*/
/*                 {{ attr_base.statuses|raw }}*/
/*             </td>*/
/*         </tr>*/
/*         {% for endpoint in endpoints_base %}*/
/*             <tr>*/
/*                 <td>*/
/*                     <strong>*/
/*                         {{ strings.endpoint|format( endpoint.key ) }}*/
/*                     </strong>*/
/*                 </td>*/
/* */
/*                 <td class="wpml-col-url">*/
/*                     <img src="{{ endpoint.flag }}" />*/
/*                     <strong>{{ endpoint.orig_value }}</strong>*/
/*                 </td>*/
/* */
/*                 <td class="wpml-col-languages">*/
/*                     {{ endpoint.statuses|raw }}*/
/*                 </td>*/
/*             </tr>*/
/*         {% endfor %}*/
/*     </tbody>*/
/* </table>*/
/* */
/* */
/* {{ nonces.edit_base|raw }}*/
/* {{ nonces.update_base|raw }}*/
