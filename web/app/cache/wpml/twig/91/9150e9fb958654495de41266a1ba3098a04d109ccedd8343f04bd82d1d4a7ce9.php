<?php

/* plugins-wrap.twig */
class __TwigTemplate_5a6fa7b9b1bacfd2d62415522f99360330f19d432d48f1fbff9ff0ef48da0947 extends Twig_Template
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

    <nav class=\"wcml-tabs wpml-tabs\" style=\"display:table;margin-top:30px;\">
        <a class=\"nav-tab nav-tab-active\" href=\"";
        // line 5
        echo twig_escape_filter($this->env, (isset($context["link_url"]) ? $context["link_url"] : null));
        echo "\" >";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "required", array()), "html", null, true);
        echo "</a>
    </nav>

    <div class=\"wcml-wrap\">
        <div class=\"wcml-section\">
            <div class=\"wcml-section-header\">
                <h3>
                    ";
        // line 12
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "plugins", array()), "html", null, true);
        echo "
                    <i class=\"otgs-ico-help wcml-tip\"
                       data-tip=\"";
        // line 14
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "depends", array()), "html", null, true);
        echo "\"></i>
                </h3>
            </div>
            <div class=\"wcml-section-content wcml-section-content-wide\">
                <ul>
                    ";
        // line 19
        if ((isset($context["old_wpml"]) ? $context["old_wpml"] : null)) {
            // line 20
            echo "                        <li>
                            <i class=\"otgs-ico-warning\"></i>
                            ";
            // line 22
            echo $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "old_wpml_link", array());
            echo "
                            <a href=\"";
            // line 23
            echo twig_escape_filter($this->env, (isset($context["tracking_link"]) ? $context["tracking_link"] : null), "html", null, true);
            echo "\"
                               target=\"_blank\">";
            // line 24
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "update_wpml", array()), "html", null, true);
            echo "</a>
                        </li>
                    ";
        } elseif ( !        // line 26
(isset($context["check_design_update"]) ? $context["check_design_update"] : null)) {
            // line 27
            echo "                        <li>
                            <i class=\"otgs-ico-warning\"></i>
                            ";
            // line 29
            echo $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "new_design_wpml_link", array());
            echo "
                            <p>
                                <a class=\"button-primary\" href=\"";
            // line 31
            echo twig_escape_filter($this->env, (isset($context["install_wpml_link"]) ? $context["install_wpml_link"] : null), "html", null, true);
            echo "\"
                                   target=\"_blank\">";
            // line 32
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "upgrade_wpml", array()), "html", null, true);
            echo "</a>
                            </p>
                        </li>
                    ";
        } elseif (        // line 35
(isset($context["icl_version"]) ? $context["icl_version"] : null)) {
            // line 36
            echo "                        <li>
                            <i class=\"otgs-ico-ok\"></i>
                            ";
            // line 38
            echo sprintf($this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "inst_active", array()), $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "wpml", array()));
            echo "
                        </li>
                        ";
            // line 40
            if ((isset($context["icl_setup"]) ? $context["icl_setup"] : null)) {
                // line 41
                echo "                            <li>
                                <i class=\"otgs-ico-ok\"></i>
                                ";
                // line 43
                echo sprintf($this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "is_setup", array()), $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "wpml", array()));
                echo "
                            </li>
                        ";
            } else {
                // line 46
                echo "                            <li>
                                <i class=\"otgs-ico-warning\"></i>
                                ";
                // line 48
                echo sprintf($this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "not_setup", array()), $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "wpml", array()));
                echo "
                            </li>
                        ";
            }
            // line 51
            echo "                    ";
        } else {
            // line 52
            echo "                        <li>
                            <i class=\"otgs-ico-warning\"></i>
                            ";
            // line 54
            echo $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "wpml_not_inst", array());
            echo "
                            <a href=\"";
            // line 55
            echo twig_escape_filter($this->env, (isset($context["install_wpml_link"]) ? $context["install_wpml_link"] : null));
            echo "\" target=\"_blank\">";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "get_wpml", array()), "html", null, true);
            echo "</a>
                        </li>
                    ";
        }
        // line 58
        echo "
                    ";
        // line 59
        if ((isset($context["media_version"]) ? $context["media_version"] : null)) {
            // line 60
            echo "                        <li>
                            <i class=\"otgs-ico-ok\"></i>
                            ";
            // line 62
            echo sprintf($this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "inst_active", array()), $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "media", array()));
            echo "
                        </li>
                    ";
        } else {
            // line 65
            echo "                        <li>
                            <i class=\"otgs-ico-warning\"></i>
                            ";
            // line 67
            echo sprintf($this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "not_inst", array()), $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "media", array()));
            echo "
                            <a href=\"";
            // line 68
            echo twig_escape_filter($this->env, (isset($context["install_wpml_link"]) ? $context["install_wpml_link"] : null));
            echo "\" target=\"_blank\">";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "get_wpml_media", array()), "html", null, true);
            echo "</a>
                        </li>
                    ";
        }
        // line 71
        echo "
                    ";
        // line 72
        if ((isset($context["tm_version"]) ? $context["tm_version"] : null)) {
            // line 73
            echo "                        <li>
                            <i class=\"otgs-ico-ok\"></i>
                            ";
            // line 75
            echo sprintf($this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "inst_active", array()), $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "tm", array()));
            echo "
                        </li>
                    ";
        } else {
            // line 78
            echo "                        <li>
                            <i class=\"otgs-ico-warning\"></i>
                            ";
            // line 80
            echo sprintf($this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "not_inst", array()), $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "tm", array()));
            echo "
                            <a href=\"";
            // line 81
            echo twig_escape_filter($this->env, (isset($context["install_wpml_link"]) ? $context["install_wpml_link"] : null));
            echo "\" target=\"_blank\">";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "get_wpml_tm", array()), "html", null, true);
            echo "</a>
                        </li>
                    ";
        }
        // line 84
        echo "
                    ";
        // line 85
        if ((isset($context["st_version"]) ? $context["st_version"] : null)) {
            // line 86
            echo "                        <li>
                            <i class=\"otgs-ico-ok\"></i>
                            ";
            // line 88
            echo sprintf($this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "inst_active", array()), $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "st", array()));
            echo "
                        </li>
                    ";
        } else {
            // line 91
            echo "                        <li>
                            <i class=\"otgs-ico-warning\"></i>
                            ";
            // line 93
            echo sprintf($this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "not_inst", array()), $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "st", array()));
            echo "
                            <a href=\"";
            // line 94
            echo twig_escape_filter($this->env, (isset($context["install_wpml_link"]) ? $context["install_wpml_link"] : null));
            echo "\" target=\"_blank\">";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "get_wpml_st", array()), "html", null, true);
            echo "</a>
                        </li>
                    ";
        }
        // line 97
        echo "
                    ";
        // line 98
        if ((isset($context["old_wc"]) ? $context["old_wc"] : null)) {
            // line 99
            echo "                        <li>
                            <i class=\"otgs-ico-warning\"></i>
                            ";
            // line 101
            echo $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "old_wc", array());
            echo "
                            <a href=\"";
            // line 102
            echo twig_escape_filter($this->env, (isset($context["wc_link"]) ? $context["wc_link"] : null));
            echo "\" target=\"_blank\">";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "download_wc", array()), "html", null, true);
            echo "</a>
                        </li>
                    ";
        } elseif (        // line 104
(isset($context["wc"]) ? $context["wc"] : null)) {
            // line 105
            echo "                        <li>
                            <i class=\"otgs-ico-ok\"></i>
                            ";
            // line 107
            echo sprintf($this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "inst_active", array()), $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "wc", array()));
            echo "
                        </li>
                    ";
        } else {
            // line 110
            echo "                        <li>
                            <i class=\"otgs-ico-warning\"></i>
                            ";
            // line 112
            echo sprintf($this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "not_inst", array()), $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "wc", array()));
            echo "
                            <a href=\"";
            // line 113
            echo twig_escape_filter($this->env, (isset($context["wc_link"]) ? $context["wc_link"] : null));
            echo "\" target=\"_blank\">";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["strings"]) ? $context["strings"] : null), "download_wc", array()), "html", null, true);
            echo "</a>
                        </li>
                    ";
        }
        // line 116
        echo "                </ul>
            </div>
        </div>
    </div>
</div>

";
    }

    public function getTemplateName()
    {
        return "plugins-wrap.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  286 => 116,  278 => 113,  274 => 112,  270 => 110,  264 => 107,  260 => 105,  258 => 104,  251 => 102,  247 => 101,  243 => 99,  241 => 98,  238 => 97,  230 => 94,  226 => 93,  222 => 91,  216 => 88,  212 => 86,  210 => 85,  207 => 84,  199 => 81,  195 => 80,  191 => 78,  185 => 75,  181 => 73,  179 => 72,  176 => 71,  168 => 68,  164 => 67,  160 => 65,  154 => 62,  150 => 60,  148 => 59,  145 => 58,  137 => 55,  133 => 54,  129 => 52,  126 => 51,  120 => 48,  116 => 46,  110 => 43,  106 => 41,  104 => 40,  99 => 38,  95 => 36,  93 => 35,  87 => 32,  83 => 31,  78 => 29,  74 => 27,  72 => 26,  67 => 24,  63 => 23,  59 => 22,  55 => 20,  53 => 19,  45 => 14,  40 => 12,  28 => 5,  22 => 2,  19 => 1,);
    }
}
/* <div class="wrap">*/
/*     <h1>{{ strings.title }}</h1>*/
/* */
/*     <nav class="wcml-tabs wpml-tabs" style="display:table;margin-top:30px;">*/
/*         <a class="nav-tab nav-tab-active" href="{{ link_url|e }}" >{{ strings.required }}</a>*/
/*     </nav>*/
/* */
/*     <div class="wcml-wrap">*/
/*         <div class="wcml-section">*/
/*             <div class="wcml-section-header">*/
/*                 <h3>*/
/*                     {{ strings.plugins }}*/
/*                     <i class="otgs-ico-help wcml-tip"*/
/*                        data-tip="{{ strings.depends }}"></i>*/
/*                 </h3>*/
/*             </div>*/
/*             <div class="wcml-section-content wcml-section-content-wide">*/
/*                 <ul>*/
/*                     {% if old_wpml %}*/
/*                         <li>*/
/*                             <i class="otgs-ico-warning"></i>*/
/*                             {{ strings.old_wpml_link|raw }}*/
/*                             <a href="{{ tracking_link }}"*/
/*                                target="_blank">{{ strings.update_wpml }}</a>*/
/*                         </li>*/
/*                     {% elseif not check_design_update  %}*/
/*                         <li>*/
/*                             <i class="otgs-ico-warning"></i>*/
/*                             {{ strings.new_design_wpml_link|raw }}*/
/*                             <p>*/
/*                                 <a class="button-primary" href="{{ install_wpml_link }}"*/
/*                                    target="_blank">{{ strings.upgrade_wpml }}</a>*/
/*                             </p>*/
/*                         </li>*/
/*                     {% elseif icl_version %}*/
/*                         <li>*/
/*                             <i class="otgs-ico-ok"></i>*/
/*                             {{ strings.inst_active|format( strings.wpml )|raw }}*/
/*                         </li>*/
/*                         {% if icl_setup %}*/
/*                             <li>*/
/*                                 <i class="otgs-ico-ok"></i>*/
/*                                 {{ strings.is_setup|format( strings.wpml )|raw }}*/
/*                             </li>*/
/*                         {% else %}*/
/*                             <li>*/
/*                                 <i class="otgs-ico-warning"></i>*/
/*                                 {{ strings.not_setup|format( strings.wpml )|raw }}*/
/*                             </li>*/
/*                         {% endif %}*/
/*                     {% else %}*/
/*                         <li>*/
/*                             <i class="otgs-ico-warning"></i>*/
/*                             {{ strings.wpml_not_inst|raw }}*/
/*                             <a href="{{ install_wpml_link|e }}" target="_blank">{{ strings.get_wpml }}</a>*/
/*                         </li>*/
/*                     {% endif %}*/
/* */
/*                     {% if media_version %}*/
/*                         <li>*/
/*                             <i class="otgs-ico-ok"></i>*/
/*                             {{ strings.inst_active|format( strings.media )|raw }}*/
/*                         </li>*/
/*                     {% else %}*/
/*                         <li>*/
/*                             <i class="otgs-ico-warning"></i>*/
/*                             {{ strings.not_inst|format( strings.media )|raw }}*/
/*                             <a href="{{ install_wpml_link|e }}" target="_blank">{{ strings.get_wpml_media }}</a>*/
/*                         </li>*/
/*                     {% endif %}*/
/* */
/*                     {% if tm_version %}*/
/*                         <li>*/
/*                             <i class="otgs-ico-ok"></i>*/
/*                             {{ strings.inst_active|format( strings.tm )|raw }}*/
/*                         </li>*/
/*                     {% else %}*/
/*                         <li>*/
/*                             <i class="otgs-ico-warning"></i>*/
/*                             {{ strings.not_inst|format( strings.tm )|raw }}*/
/*                             <a href="{{ install_wpml_link|e }}" target="_blank">{{ strings.get_wpml_tm }}</a>*/
/*                         </li>*/
/*                     {% endif %}*/
/* */
/*                     {% if st_version %}*/
/*                         <li>*/
/*                             <i class="otgs-ico-ok"></i>*/
/*                             {{ strings.inst_active|format( strings.st )|raw }}*/
/*                         </li>*/
/*                     {% else %}*/
/*                         <li>*/
/*                             <i class="otgs-ico-warning"></i>*/
/*                             {{ strings.not_inst|format( strings.st )|raw }}*/
/*                             <a href="{{ install_wpml_link|e }}" target="_blank">{{ strings.get_wpml_st }}</a>*/
/*                         </li>*/
/*                     {% endif %}*/
/* */
/*                     {% if old_wc %}*/
/*                         <li>*/
/*                             <i class="otgs-ico-warning"></i>*/
/*                             {{ strings.old_wc|raw }}*/
/*                             <a href="{{ wc_link|e }}" target="_blank">{{ strings.download_wc }}</a>*/
/*                         </li>*/
/*                     {% elseif wc %}*/
/*                         <li>*/
/*                             <i class="otgs-ico-ok"></i>*/
/*                             {{ strings.inst_active|format( strings.wc )|raw }}*/
/*                         </li>*/
/*                     {% else %}*/
/*                         <li>*/
/*                             <i class="otgs-ico-warning"></i>*/
/*                             {{ strings.not_inst|format( strings.wc )|raw }}*/
/*                             <a href="{{ wc_link|e }}" target="_blank">{{ strings.download_wc }}</a>*/
/*                         </li>*/
/*                     {% endif %}*/
/*                 </ul>*/
/*             </div>*/
/*         </div>*/
/*     </div>*/
/* </div>*/
/* */
/* */
