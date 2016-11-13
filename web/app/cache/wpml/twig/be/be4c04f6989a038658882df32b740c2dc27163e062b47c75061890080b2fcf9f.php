<?php

/* trnsl-attributes.twig */
class __TwigTemplate_10c038d4e841b3b654a5d3bbc66a465e7ad8a784303356b7d9cb8daac55631b6 extends Twig_Template
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
        if ((isset($context["edit_mode"]) ? $context["edit_mode"] : null)) {
            // line 2
            echo "    <div class=\"wcml-is-translatable-attr-block\" style=\"display: none\">
        <table>
            <tr class=\"form-field\">
                <th scope=\"row\" valign=\"top\">
                    <label for=\"wcml-is-translatable-attr\">";
            // line 6
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "label", array()), "html", null, true);
            echo "</label>
                </th>
                <td>
                    <input name=\"wcml-is-translatable-attr\" id=\"wcml-is-translatable-attr\" type=\"checkbox\" value=\"1\" ";
            // line 9
            if ((isset($context["checked"]) ? $context["checked"] : null)) {
                echo " checked=\"checked\" ";
            }
            echo " />
                    <p class=\"description\">";
            // line 10
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "description", array()), "html", null, true);
            echo "</p>
                </td>
            </tr>
        </table>
    </div>
    <input type=\"hidden\" id=\"wcml-is-translatable-attr-notice\" value=\"";
            // line 15
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "notice", array()), "html", null, true);
            echo "\" />
";
        } else {
            // line 17
            echo "    <div class=\"wcml-is-translatable-attr-block\" style=\"display: none\">
        <div class=\"form-field\">
            <label for=\"wcml-is-translatable-attr\">
                <input name=\"wcml-is-translatable-attr\" id=\"wcml-is-translatable-attr\" type=\"checkbox\" value=\"1\" ";
            // line 20
            if ((isset($context["checked"]) ? $context["checked"] : null)) {
                echo " checked=\"checked\" ";
            }
            echo " />
                ";
            // line 21
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "label", array()), "html", null, true);
            echo "
            </label>
            <p class=\"description\">";
            // line 23
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "description", array()), "html", null, true);
            echo "</p>
        </div>
    </div>
";
        }
    }

    public function getTemplateName()
    {
        return "trnsl-attributes.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  68 => 23,  63 => 21,  57 => 20,  52 => 17,  47 => 15,  39 => 10,  33 => 9,  27 => 6,  21 => 2,  19 => 1,);
    }
}
/* {% if edit_mode %}*/
/*     <div class="wcml-is-translatable-attr-block" style="display: none">*/
/*         <table>*/
/*             <tr class="form-field">*/
/*                 <th scope="row" valign="top">*/
/*                     <label for="wcml-is-translatable-attr">{{ strings.label }}</label>*/
/*                 </th>*/
/*                 <td>*/
/*                     <input name="wcml-is-translatable-attr" id="wcml-is-translatable-attr" type="checkbox" value="1" {% if checked %} checked="checked" {% endif %} />*/
/*                     <p class="description">{{ strings.description }}</p>*/
/*                 </td>*/
/*             </tr>*/
/*         </table>*/
/*     </div>*/
/*     <input type="hidden" id="wcml-is-translatable-attr-notice" value="{{ strings.notice }}" />*/
/* {% else %}*/
/*     <div class="wcml-is-translatable-attr-block" style="display: none">*/
/*         <div class="form-field">*/
/*             <label for="wcml-is-translatable-attr">*/
/*                 <input name="wcml-is-translatable-attr" id="wcml-is-translatable-attr" type="checkbox" value="1" {% if checked %} checked="checked" {% endif %} />*/
/*                 {{ strings.label }}*/
/*             </label>*/
/*             <p class="description">{{ strings.description }}</p>*/
/*         </div>*/
/*     </div>*/
/* {% endif %}*/
