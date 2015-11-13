<?php

class MY_Pagination extends CI_Pagination {

    var $js_function = 'ajax_pagnav';
    var $next_link = 'Next';
    var $prev_link = 'Prev';
    var $first_link = '«First';
    var $last_link = 'Last»';
    var $show_total = 'no';
    var $show_text_total = 'of';
    var $show_num = 'yes';
    var $show_button = 'yes';
    var $show_first_last = 'yes';
    var $first_class = 'prevnext';
    var $last_class = 'prevnext';
    var $next_class = 'next';
    var $prev_class = 'prev';
    var $num_class = 'number';
    var $cur_class = 'currentpage';
    var $title_link = 'Page';
    var $total_tag_open = '';
    var $total_tag_close = '';
    var $page_string = 'p';
    var $num_space = '';
    var $ext = ".html";

    function __construct($params = array()) {
        parent::__construct($params);
    }

    function display_ajax() {
        $this->full_tag_open = '';
        $this->full_tag_close = '';
        $this->first_tag_open = '';
        $this->first_tag_close = '';
        $this->prev_tag_open = '';
        $this->prev_tag_close = '';
        $this->cur_tag_open = '';
        $this->cur_tag_close = '';
        $this->num_tag_open = '';
        $this->num_tag_close = '';
        $this->next_tag_open = '';
        $this->next_tag_close = '';
        $this->last_tag_open = '';
        $this->last_tag_close = '';
        $this->show_first_last = '';
        $this->prev_link = '[Trang trước]';
        $this->next_link = '[Trang sau]';
        $this->next_class = 'page';
        $this->prev_class = 'page';
        $this->title_link = 'Trang';
        $this->show_num = 'no';
        $this->num_space = "&nbsp;";
        $pagination = '';
        $total = ceil($this->total_rows / $this->per_page);
        if ($total > 1) {
            $first = 0;
            $end = 0;
            if ($this->cur_page != 1) {
                $first = $this->cur_page - 3;
                if ($first <= 0) {
                    $first = 1;
                    $end = 4 - $this->cur_page;
                }
                $end = $end + $this->cur_page + 3;
                if ($end > $total) {
                    $end = $total;
                    $first = $total - 6;
                    if ($first <= 0) {
                        $first = 1;
                    }
                }
            } else {
                $first = 1;
                $end = 7;
                if ($end > $total) {
                    $end = $total;
                }
            }

            $pagination.= $this->full_tag_open;
            if ($this->show_button == 'yes') {
                if ($this->cur_page > 1) {
                    if ($this->show_first_last == 'yes') {
                        $pagination .= $this->first_tag_open;
                        $pagination .= "<a href='javascript:void(0)' onclick='" . $this->js_function . "(1" . ")'>" . $this->first_link . "</a>";
                        $pagination .= $this->first_tag_close;
                    }

                    $pagination .= $this->prev_tag_open;
                    $pagination .= "<a href='javascript:void(0)' class='" . $this->prev_class . "' onclick='" . $this->js_function . "(" . ($this->cur_page - 1) . ")'>" . $this->prev_link . "</a>";
                    $pagination .= $this->prev_tag_close;
                }
            }
            //else
            //{
            //$pagination.=	$this->first_tag_open;
            //$pagination.=	'<span>'.$this->first_link.'</span>';
            //$pagination.=	$this->first_tag_close;
            //$pagination.=	$this->prev_tag_open;
            //$pagination.=	'<span>'.$this->prev_link.'</span>';
            //$pagination.=	$this->prev_tag_close;
            //}

            if ($this->show_num == 'yes') {
                for ($i = $first; $i <= $end; $i++) {
                    if ($i == $this->cur_page) {
                        $pagination .= $this->num_tag_open;
                        $pagination .= '<b>' . $i . '</b>';
                        $pagination .= $this->num_tag_close;
                    } else {
                        $pagination .= $this->num_tag_open;
                        $pagination .= "<a href='javascript:void(0)' class='number' onclick='" . $this->js_function . "(" . $i . ")'>" . $i . "</a>";
                        $pagination .= $this->num_tag_close;
                    }
                }
            }

            if ($this->show_total == 'yes')
                $pagination .= '<span> ' . $this->show_text_total . '&nbsp;' . $total . '</span>';

            if ($this->show_button == 'yes') {
                if ($this->cur_page < $total) {

                    $pagination.= $this->next_tag_open;
                    $pagination.= "<a href='javascript:void(0)' class='" . $this->next_class . "' onclick='" . $this->js_function . "(" . ($this->cur_page + 1) . ")'>" . $this->next_link . "</a>";
                    $pagination.= $this->next_tag_close;

                    if ($this->show_first_last == 'yes') {
                        $pagination.= $this->last_tag_open;
                        $pagination.= "<a href='javascript:void(0)' onclick='" . $this->js_function . "(" . $total . ")'>" . $this->last_link . "</a>";
                        $pagination.= $this->last_tag_close;
                    }
                }
            }
            //else
            //{
            //$pagination .= $this->next_tag_open;
            //$pagination .= '<span>'.$this->next_link.'</span>';
            //$pagination .= $this->next_tag_close;
            //$pagination .=	$this->last_tag_open;
            //$pagination .=	'<span>'.$this->last_link.'</span>';
            //$pagination .=	$this->last_tag_close;
            //}

            $pagination.= $this->full_tag_close;
        }
        return $pagination;
    }

    function ajax_url() {
        $this->full_tag_open = '';
        $this->full_tag_close = '';
        $this->first_tag_open = '';
        $this->first_tag_close = '';
        $this->prev_tag_open = '';
        $this->prev_tag_close = '';
        $this->cur_tag_open = '';
        $this->cur_tag_close = '';
        $this->num_tag_open = '';
        $this->num_tag_close = '';
        $this->next_tag_open = '';
        $this->next_tag_close = '';
        $this->last_tag_open = '';
        $this->last_tag_close = '';
        $this->show_first_last = '';
        $this->prev_link = '[Trang trước]';
        $this->next_link = '[Trang sau]';
        $this->next_class = 'page';
        $this->prev_class = 'page';
        $this->title_link = 'Trang';
        $this->show_num = 'no';
        $this->num_space = "&nbsp;";
        $pagination = '';
        $total = ceil($this->total_rows / $this->per_page);
        if ($total > 1) {
            $first = 0;
            $end = 0;
            if ($this->cur_page != 1) {
                $first = $this->cur_page - 3;
                if ($first <= 0) {
                    $first = 1;
                    $end = 4 - $this->cur_page;
                }
                $end = $end + $this->cur_page + 3;
                if ($end > $total) {
                    $end = $total;
                    $first = $total - 6;
                    if ($first <= 0) {
                        $first = 1;
                    }
                }
            } else {
                $first = 1;
                $end = 7;
                if ($end > $total) {
                    $end = $total;
                }
            }

            $pagination.= $this->full_tag_open;

            if ($this->cur_page > 1) {
                $pagination .= $this->first_tag_open;
                $pagination .= "<a href='javascript:void(0)' onclick=" . $this->js_function . "('" . $this->base_url . "')>" . $this->first_link . "</a>";
                $pagination .= $this->first_tag_close;

                $pagination .= $this->prev_tag_open;
                $pagination .= "<a href='javascript:void(0)' onclick=" . $this->js_function . "('" . $this->base_url . "/" . ($this->cur_page - 1) . "')>" . $this->prev_link . "</a>";
                $pagination .= $this->prev_tag_close;
            }

            for ($i = $first; $i <= $end; $i++) {

                if ($i == $this->cur_page) {
                    $pagination .= $this->num_tag_open;
                    $pagination .= '<a class="currentpage">' . $i . '</a>';
                    $pagination .= $this->num_tag_close;
                } else {
                    $pagination .= $this->num_tag_open;
                    $pagination .= "<a href='javascript:void(0)' class='number' onclick=" . $this->js_function . "('" . $this->base_url . "/" . $i . "')>" . $i . "</a>";
                    $pagination .= $this->num_tag_close;
                }
            }

            if ($this->show_total == 'yes')
                $pagination .= '<span> ' . $this->show_text_total . '&nbsp;' . $total . '</span>';

            if ($this->cur_page < $total) {
                $pagination.= $this->next_tag_open;
                $pagination.= "<a href='javascript:void(0)' onclick=" . $this->js_function . "('" . $this->base_url . "/" . ($this->cur_page + 1) . "')>" . $this->next_link . "</a>";
                $pagination.= $this->next_tag_close;

                $pagination.= $this->last_tag_open;
                $pagination.= "<a href='javascript:void(0)' onclick=" . $this->js_function . "('" . $this->base_url . "/" . $total . "')>" . $this->last_link . "</a>";
                $pagination.= $this->last_tag_close;
            }

            $pagination.= $this->full_tag_close;
        }
        return $pagination;
    }

    function ajax_query_string() {
        $this->base_url = preg_replace("/(&|\?)" . $this->page_string . "=[0-9]?/", "", $this->base_url);

        $pagination = '';
        $total = ceil($this->total_rows / $this->per_page);
        if ($total > 1) {
            $first = 0;
            $end = 0;
            if ($this->cur_page != 1) {
                $first = $this->cur_page - 3;
                if ($first <= 0) {
                    $first = 1;
                    $end = 4 - $this->cur_page;
                }
                $end = $end + $this->cur_page + 3;
                if ($end > $total) {
                    $end = $total;
                    $first = $total - 6;
                    if ($first <= 0) {
                        $first = 1;
                    }
                }
            } else {
                $first = 1;
                $end = 7;
                if ($end > $total) {
                    $end = $total;
                }
            }

            $pagination.= $this->full_tag_open;

            if ($this->cur_page > 1) {
                $pagination .= $this->first_tag_open;
                $pagination .= "<a href='javascript:void(0)' onclick=" . $this->js_function . "('" . $this->base_url . "')>" . $this->first_link . "</a>";
                $pagination .= $this->first_tag_close;

                $pagination .= $this->prev_tag_open;
                $pagination .= "<a href='javascript:void(0)' onclick=" . $this->js_function . "('" . ((strpos($this->base_url, "?") == false) ? $this->base_url . "?" . $this->page_string . "=" . ($this->cur_page - 1) : $this->base_url . "&" . $this->page_string . "=" . ($this->cur_page - 1)) . "')>" . $this->prev_link . "</a>";
                $pagination .= $this->prev_tag_close;
            }

            for ($i = $first; $i <= $end; $i++) {

                if ($i == $this->cur_page) {
                    $pagination .= $this->num_tag_open;
                    $pagination .= '<a class="currentpage">' . $i . '</a>';
                    $pagination .= $this->num_tag_close;
                } else {
                    $pagination .= $this->num_tag_open;
                    $pagination .= "<a href='javascript:void(0)' class='number' onclick=" . $this->js_function . "('" . ((strpos($this->base_url, "?") == false) ? $this->base_url . "?" . $this->page_string . "=" . $i : $this->base_url . "&" . $this->page_string . "=" . $i) . "')>" . $i . "</a>";
                    $pagination .= $this->num_tag_close;
                }
            }

            if ($this->show_total == 'yes')
                $pagination .= '<span> ' . $this->show_text_total . '&nbsp;' . $total . '</span>';

            if ($this->cur_page < $total) {
                $pagination.= $this->next_tag_open;
                $pagination.= "<a href='javascript:void(0)' onclick=" . $this->js_function . "('" . ((strpos($this->base_url, "?") == false) ? $this->base_url . "?" . $this->page_string . "=" . ($this->cur_page + 1) : $this->base_url . "&" . $this->page_string . "=" . ($this->cur_page + 1)) . "')>" . $this->next_link . "</a>";
                $pagination.= $this->next_tag_close;

                $pagination.= $this->last_tag_open;
                $pagination.= "<a href='javascript:void(0)' onclick=" . $this->js_function . "('" . ((strpos($this->base_url, "?") == false) ? $this->base_url . "?" . $this->page_string . "=" . $total : $this->base_url . "&" . $this->page_string . "=" . $total) . "')>" . $this->last_link . "</a>";
                $pagination.= $this->last_tag_close;
            }

            $pagination.= $this->full_tag_close;
        }
        return $pagination;
    }

    function display_ajax2() {
        $first = 0;
        $end = 0;
        if ($this->cur_page != 1) {
            $first = $this->cur_page - 3;
            if ($first <= 0) {
                $first = 1;
                $end = 4 - $this->cur_page;
            }
            $end = $end + $this->cur_page + 3;
            if ($end > $total) {
                $end = $total;
                $first = $total - 6;
                if ($first <= 0) {
                    $first = 1;
                }
            }
        } else {
            $first = 1;
            $end = 7;
            if ($end > $total) {
                $end = $total;
            }
        }

        $pagination = '';

        $pagination.= $this->full_tag_open;

        if ($this->cur_page > 1) {
            $pagination .= $this->first_tag_open;
            $pagination .= "<a href='javascript:void(0)' onclick=" . $this->js_function . "('" . $this->base_url . "/1'" . ")>" . $this->first_link . "</a>";
            $pagination .= $this->first_tag_close;

            $pagination .= $this->prev_tag_open;
            $pagination .= "<a href='javascript:void(0)' onclick=" . $this->js_function . "('" . $this->base_url . "/" . ($this->cur_page - 1) . "')>" . $this->prev_link . "</a>";
            $pagination .= $this->prev_tag_close;
        } else {
            $pagination.= $this->first_tag_open;
            $pagination.= '<span>' . $this->first_link . '</span>';
            $pagination.= $this->first_tag_close;

            $pagination.= $this->prev_tag_open;
            $pagination.= '<span>' . $this->prev_link . '</span>';
            $pagination.= $this->prev_tag_close;
        }

        for ($i = $first; $i <= $end; $i++) {

            if ($i == $this->cur_page) {
                $pagination .= $this->num_tag_open;
                $pagination .= '<a id="current" class="number">' . $i . '</a>';
                $pagination .= $this->num_tag_close;
            } else {
                $pagination .= $this->num_tag_open;
                $pagination .= "<a href='javascript:void(0)' class='number' onclick=" . $this->js_function . "('" . $this->base_url . "/" . $i . "')>" . $i . "</a>";
                $pagination .= $this->num_tag_close;
            }
        }
        if ($this->cur_page < $total) {
            $pagination.= $this->next_tag_open;
            $pagination.= "<a href='javascript:void(0)' onclick=" . $this->js_function . "('" . $this->base_url . "/" . ($this->cur_page + 1) . "')>" . $this->next_link . "</a>";
            $pagination.= $this->next_tag_close;

            $pagination.= $this->last_tag_open;
            $pagination.= "<a href='javascript:void(0)' onclick=" . $this->js_function . "('" . $this->base_url . "/" . $total . "')>" . $this->last_link . "</a>";
            $pagination.= $this->last_tag_close;
        } else {
            $pagination .= $this->next_tag_open;
            $pagination .= '<span>' . $this->next_link . '</span>';
            $pagination .= $this->next_tag_close;

            $pagination .= $this->last_tag_open;
            $pagination .= '<span>' . $this->last_link . '</span>';
            $pagination .= $this->last_tag_close;
        }

        $pagination.= $this->full_tag_close;
        return $pagination;
    }

    function display_ul_li() {
        /*
          'full_tag_open'	=>	'<ul class="page">',
          'full_tag_close'=>	'</ul>',
          'first_tag_open'=>	'<li class="first">',
          'prev_tag_open' =>	'<li>',
          'next_tag_open' =>	'<li>',
          'last_tag_open' =>	'<li class="last">',
          'num_tag_open'	=>	'<li>',
          'cur_tag_open'	=>	'<li class="current">'
         */
        $this->full_tag_open = '<ul class="page">';
        $this->full_tag_close = '</ul>';
        $this->first_tag_open = '<li class="first">';
        $this->first_tag_close = '</li>';
        $this->prev_tag_open = '<li>';
        $this->prev_tag_close = '</li>';
        $this->cur_tag_open = '<li class="current">';
        $this->cur_tag_close = '</li>';
        $this->num_tag_open = '<li>';
        $this->num_tag_close = '</li>';
        $this->next_tag_open = '<li>';
        $this->next_tag_close = '</li>';
        $this->last_tag_open = '<li class="last">';
        $this->last_tag_close = '</li>';
        $this->show_first_last = 'no';
        $this->prev_link = '‹';
        $this->next_link = '›';
        $this->title_link = 'Trang';

        $pagination = '';
        $total = ceil($this->total_rows / $this->per_page);
        if ($total > 1) {
            $first = 0;
            $end = 0;
            if ($this->cur_page != 1) {
                $first = $this->cur_page - 3;
                if ($first <= 0) {
                    $first = 1;
                    $end = 4 - $this->cur_page;
                }
                $end = $end + $this->cur_page + 3;
                if ($end > $total) {
                    $end = $total;
                    $first = $total - 6;
                    if ($first <= 0) {
                        $first = 1;
                    }
                }
            } else {
                $first = 1;
                $end = 7;
                if ($end > $total) {
                    $end = $total;
                }
            }

            $pagination.= $this->full_tag_open;

            if ($this->cur_page > 1) {
                if ($this->show_first_last == 'yes') {
                    $pagination .= $this->first_tag_open;
                    $pagination .= "<a href='" . $this->base_url . "/" . "'>" . $this->first_link . "</a>";
                    $pagination .= $this->first_tag_close;
                }

                $pagination .= $this->prev_tag_open;
                if (($this->cur_page - 1) == 1)
                    $pagination .= "<a class='" . $this->prev_class . "' href='" . $this->base_url . "/" . "'>" . $this->prev_link . "</a>" . $this->num_space;
                else
                    $pagination .= "<a class='" . $this->prev_class . "' href='" . $this->base_url . "/" . ($this->cur_page - 1) . "/'>" . $this->prev_link . "</a>" . $this->num_space;
                $pagination .= $this->prev_tag_close;
            }
            else {
                if ($this->show_first_last == 'yes') {
                    $pagination .= $this->first_tag_open;
                    $pagination .= "<a href='javascript:;'>" . $this->first_link . "</a>";
                    $pagination .= $this->first_tag_close;
                }

                $pagination .= $this->prev_tag_open;
                if (($this->cur_page - 1) == 1)
                    $pagination .= "<a class='" . $this->prev_class . "' href='javascript:;'>" . $this->prev_link . "</a>" . $this->num_space;
                else
                    $pagination .= "<a class='" . $this->prev_class . "' href='javascript:;'>" . $this->prev_link . "</a>" . $this->num_space;
                $pagination .= $this->prev_tag_close;
            }

            if ($this->show_num == 'yes') {
                $j = 0;
                for ($i = $first; $i <= $end; $i++) {
                    $j++;
                    if ($i == $this->cur_page) {
                        $pagination .= $this->cur_tag_open;
                        $pagination .= '' . $i . '' . $this->num_space;
                        $pagination .= $this->cur_tag_close;
                    } else {
                        $pagination .= $this->num_tag_open;
                        if ($i == 1)
                            $pagination .= "<a title='" . $this->title_link . ' ' . $i . "' class='" . $this->num_class . (($j == 7) ? ' end' : '') . "' href='" . $this->base_url . "/" . "'>" . $i . "</a>" . $this->num_space;
                        else
                            $pagination .= "<a title='" . $this->title_link . ' ' . $i . "' class='" . $this->num_class . (($j == 7) ? ' end' : '') . "' href='" . $this->base_url . "/" . $i . "/'>" . $i . "</a>" . $this->num_space;
                        $pagination .= $this->num_tag_close;
                    }
                }
            }else {
                if ($this->cur_page > 1 && $this->cur_page < $total)
                    $pagination .= $this->num_space;
            }

            if ($this->show_total == 'yes')
                $pagination .= $this->total_tag_open . 'of ' . $total . $this->total_tag_close;

            if ($this->cur_page < $total) {
                $pagination.= $this->next_tag_open;
                $pagination.= "<a class='" . $this->next_class . "' href='" . $this->base_url . "/" . ($this->cur_page + 1) . "/'>" . $this->next_link . "</a>";
                $pagination.= $this->next_tag_close;

                if ($this->show_first_last == 'yes') {
                    $pagination.= $this->last_tag_open;
                    $pagination.= "<a href='" . $this->base_url . "/" . $total . "/'>" . $this->last_link . "</a>";
                    $pagination.= $this->last_tag_close;
                }
            } else {
                $pagination.= $this->next_tag_open;
                $pagination.= "<a class='" . $this->next_class . "' href='javascript:;'>" . $this->next_link . "</a>";
                $pagination.= $this->next_tag_close;

                if ($this->show_first_last == 'yes') {
                    $pagination.= $this->last_tag_open;
                    $pagination.= "<a href='javascript:;'>" . $this->last_link . "</a>";
                    $pagination.= $this->last_tag_close;
                }
            }


            $pagination.= $this->full_tag_close;
        }
        return $pagination;
    }

    function display_news() {
        /*
          'full_tag_open'	=>	'<ul class="page">',
          'full_tag_close'=>	'</ul>',
          'first_tag_open'=>	'<li class="first">',
          'prev_tag_open' =>	'<li>',
          'next_tag_open' =>	'<li>',
          'last_tag_open' =>	'<li class="last">',
          'num_tag_open'	=>	'<li>',
          'cur_tag_open'	=>	'<li class="current">'
         */
        $this->full_tag_open = '<ul class="pager">';
        $this->full_tag_close = '</ul>';
        $this->first_tag_open = '<li class="first pager-item">';
        $this->first_tag_close = '</li>';
        $this->prev_tag_open = '<li class="pager-item">';
        $this->prev_tag_close = '</li>';
        $this->cur_tag_open = '<li class="pager-current">';
        $this->cur_tag_close = '</li>';
        $this->num_tag_open = '<li class="pager-item">';
        $this->num_tag_close = '</li>';
        $this->next_tag_open = '<li class="pager-item">';
        $this->next_tag_close = '</li>';
        $this->last_tag_open = '<li class="last pager-item">';
        $this->last_tag_close = '</li>';
        $this->show_first_last = 'no';
        $this->prev_link = '‹';
        $this->next_link = '›';
        $this->title_link = 'Trang';

        $pagination = '';
        $total = ceil($this->total_rows / $this->per_page);
        if ($total > 1) {
            $first = 0;
            $end = 0;
            if ($this->cur_page != 1) {
                $first = $this->cur_page - 3;
                if ($first <= 0) {
                    $first = 1;
                    $end = 4 - $this->cur_page;
                }
                $end = $end + $this->cur_page + 3;
                if ($end > $total) {
                    $end = $total;
                    $first = $total - 6;
                    if ($first <= 0) {
                        $first = 1;
                    }
                }
            } else {
                $first = 1;
                $end = 7;
                if ($end > $total) {
                    $end = $total;
                }
            }

            $pagination.= $this->full_tag_open;

            if ($this->cur_page > 1) {
                if ($this->show_first_last == 'yes') {
                    $pagination .= $this->first_tag_open;
                    $pagination .= "<a href='" . $this->base_url . "/" . "'>" . $this->first_link . "</a>";
                    $pagination .= $this->first_tag_close;
                }

                $pagination .= $this->prev_tag_open;
                if (($this->cur_page - 1) == 1)
                    $pagination .= "<a class='" . $this->prev_class . "' href='" . $this->base_url . "/" . "'>" . $this->prev_link . "</a>" . $this->num_space;
                else
                    $pagination .= "<a class='" . $this->prev_class . "' href='" . $this->base_url . "/" . ($this->cur_page - 1) . "/'>" . $this->prev_link . "</a>" . $this->num_space;
                $pagination .= $this->prev_tag_close;
            }
            else {
                if ($this->show_first_last == 'yes') {
                    $pagination .= $this->first_tag_open;
                    $pagination .= "<a href='javascript:;'>" . $this->first_link . "</a>";
                    $pagination .= $this->first_tag_close;
                }

                $pagination .= $this->prev_tag_open;
                if (($this->cur_page - 1) == 1)
                    $pagination .= "<a class='" . $this->prev_class . "' href='javascript:;'>" . $this->prev_link . "</a>" . $this->num_space;
                else
                    $pagination .= "<a class='" . $this->prev_class . "' href='javascript:;'>" . $this->prev_link . "</a>" . $this->num_space;
                $pagination .= $this->prev_tag_close;
            }

            if ($this->show_num == 'yes') {
                $j = 0;
                for ($i = $first; $i <= $end; $i++) {
                    $j++;
                    if ($i == $this->cur_page) {
                        $pagination .= $this->cur_tag_open;
                        $pagination .= '' . $i . '' . $this->num_space;
                        $pagination .= $this->cur_tag_close;
                    } else {
                        $pagination .= $this->num_tag_open;
                        if ($i == 1)
                            $pagination .= "<a title='" . $this->title_link . ' ' . $i . "' class='" . $this->num_class . (($j == 7) ? ' end' : '') . "' href='" . $this->base_url . "/" . "'>" . $i . "</a>" . $this->num_space;
                        else
                            $pagination .= "<a title='" . $this->title_link . ' ' . $i . "' class='" . $this->num_class . (($j == 7) ? ' end' : '') . "' href='" . $this->base_url . "/" . $i . "/'>" . $i . "</a>" . $this->num_space;
                        $pagination .= $this->num_tag_close;
                    }
                }
            }else {
                if ($this->cur_page > 1 && $this->cur_page < $total)
                    $pagination .= $this->num_space;
            }

            if ($this->show_total == 'yes')
                $pagination .= $this->total_tag_open . 'of ' . $total . $this->total_tag_close;

            if ($this->cur_page < $total) {
                $pagination.= $this->next_tag_open;
                $pagination.= "<a class='" . $this->next_class . "' href='" . $this->base_url . "/" . ($this->cur_page + 1) . "/'>" . $this->next_link . "</a>";
                $pagination.= $this->next_tag_close;

                if ($this->show_first_last == 'yes') {
                    $pagination.= $this->last_tag_open;
                    $pagination.= "<a href='" . $this->base_url . "/" . $total . "/'>" . $this->last_link . "</a>";
                    $pagination.= $this->last_tag_close;
                }
            } else {
                $pagination.= $this->next_tag_open;
                $pagination.= "<a class='" . $this->next_class . "' href='javascript:;'>" . $this->next_link . "</a>";
                $pagination.= $this->next_tag_close;

                if ($this->show_first_last == 'yes') {
                    $pagination.= $this->last_tag_open;
                    $pagination.= "<a href='javascript:;'>" . $this->last_link . "</a>";
                    $pagination.= $this->last_tag_close;
                }
            }


            $pagination.= $this->full_tag_close;
        }
        return $pagination;
    }

    function display_news_home() {
        /*
          'full_tag_open'	=>	'<ul class="page">',
          'full_tag_close'=>	'</ul>',
          'first_tag_open'=>	'<li class="first">',
          'prev_tag_open' =>	'<li>',
          'next_tag_open' =>	'<li>',
          'last_tag_open' =>	'<li class="last">',
          'num_tag_open'	=>	'<li>',
          'cur_tag_open'	=>	'<li class="current">'
         */
        $this->full_tag_open = '';
        $this->full_tag_close = '';
        $this->first_tag_open = '';
        $this->first_tag_close = '';
        $this->prev_tag_open = '';
        $this->prev_tag_close = '';
        $this->cur_tag_open = '';
        $this->cur_tag_close = '';
        $this->num_tag_open = '';
        $this->num_tag_close = '';
        $this->next_tag_open = '';
        $this->next_tag_close = '';
        $this->last_tag_open = '';
        $this->last_tag_close = '';
        $this->show_first_last = '';
        $this->prev_link = '[Trang trước]';
        $this->next_link = '[Trang sau]';
        $this->next_class = 'page';
        $this->prev_class = 'page';
        $this->title_link = 'Trang';
        $this->show_num = 'no';
        $this->num_space = "&nbsp;";

        $pagination = '';
        $total = ceil($this->total_rows / $this->per_page);
        if ($total > 1) {
            $first = 0;
            $end = 0;
            if ($this->cur_page != 1) {
                $first = $this->cur_page - 3;
                if ($first <= 0) {
                    $first = 1;
                    $end = 4 - $this->cur_page;
                }
                $end = $end + $this->cur_page + 3;
                if ($end > $total) {
                    $end = $total;
                    $first = $total - 6;
                    if ($first <= 0) {
                        $first = 1;
                    }
                }
            } else {
                $first = 1;
                $end = 7;
                if ($end > $total) {
                    $end = $total;
                }
            }

            $pagination.= $this->full_tag_open;

            if ($this->cur_page > 1) {
                if ($this->show_first_last == 'yes') {
                    $pagination .= $this->first_tag_open;
                    $pagination .= "<a href='" . $this->base_url . "/" . "'>" . $this->first_link . "</a>";
                    $pagination .= $this->first_tag_close;
                }

                $pagination .= $this->prev_tag_open;
                if (($this->cur_page - 1) == 1)
                    $pagination .= "<a class='" . $this->prev_class . "' href='" . $this->base_url . "/" . "'>" . $this->prev_link . "</a>" . $this->num_space;
                else
                    $pagination .= "<a class='" . $this->prev_class . "' href='" . $this->base_url . "/" . ($this->cur_page - 1) . "/'>" . $this->prev_link . "</a>" . $this->num_space;
                $pagination .= $this->prev_tag_close;
            }
            else {
                if ($this->show_first_last == 'yes') {
                    $pagination .= $this->first_tag_open;
                    $pagination .= "<a href='javascript:;'>" . $this->first_link . "</a>";
                    $pagination .= $this->first_tag_close;
                }

                $pagination .= $this->prev_tag_open;
                if (($this->cur_page - 1) == 1)
                    $pagination .= "<a class='" . $this->prev_class . "' href='javascript:;'>" . $this->prev_link . "</a>" . $this->num_space;
                else
                    $pagination .= "<a class='" . $this->prev_class . "' href='javascript:;'>" . $this->prev_link . "</a>" . $this->num_space;
                $pagination .= $this->prev_tag_close;
            }

            if ($this->show_num == 'yes') {
                $j = 0;
                for ($i = $first; $i <= $end; $i++) {
                    $j++;
                    if ($i == $this->cur_page) {
                        $pagination .= $this->cur_tag_open;
                        $pagination .= '' . $i . '' . $this->num_space;
                        $pagination .= $this->cur_tag_close;
                    } else {
                        $pagination .= $this->num_tag_open;
                        if ($i == 1)
                            $pagination .= "<a title='" . $this->title_link . ' ' . $i . "' class='" . $this->num_class . (($j == 7) ? ' end' : '') . "' href='" . $this->base_url . "/" . "'>" . $i . "</a>" . $this->num_space;
                        else
                            $pagination .= "<a title='" . $this->title_link . ' ' . $i . "' class='" . $this->num_class . (($j == 7) ? ' end' : '') . "' href='" . $this->base_url . "/" . $i . "/'>" . $i . "</a>" . $this->num_space;
                        $pagination .= $this->num_tag_close;
                    }
                }
            }else {
                if ($this->cur_page > 1 && $this->cur_page < $total)
                    $pagination .= $this->num_space;
            }

            if ($this->show_total == 'yes')
                $pagination .= $this->total_tag_open . 'of ' . $total . $this->total_tag_close;

            if ($this->cur_page < $total) {
                $pagination.= $this->next_tag_open;
                $pagination.= "<a class='" . $this->next_class . "' href='" . $this->base_url . "/" . ($this->cur_page + 1) . "/'>" . $this->next_link . "</a>";
                $pagination.= $this->next_tag_close;

                if ($this->show_first_last == 'yes') {
                    $pagination.= $this->last_tag_open;
                    $pagination.= "<a href='" . $this->base_url . "/" . $total . "/'>" . $this->last_link . "</a>";
                    $pagination.= $this->last_tag_close;
                }
            } else {
                $pagination.= $this->next_tag_open;
                $pagination.= "<a class='" . $this->next_class . "' href='javascript:;'>" . $this->next_link . "</a>";
                $pagination.= $this->next_tag_close;

                if ($this->show_first_last == 'yes') {
                    $pagination.= $this->last_tag_open;
                    $pagination.= "<a href='javascript:;'>" . $this->last_link . "</a>";
                    $pagination.= $this->last_tag_close;
                }
            }


            $pagination.= $this->full_tag_close;
        }
        return $pagination;
    }

    function display_ul_li_query_string() {
        $this->full_tag_open = '<ul class="item-list">';
        $this->full_tag_close = '</ul>';
        $this->first_tag_open = '<li class="first">';
        $this->first_tag_close = '</li>';
        $this->prev_tag_open = '<li>';
        $this->prev_tag_close = '</li>';
        $this->cur_tag_open = '<li class="current">';
        $this->cur_tag_close = '</li>';
        $this->num_tag_open = '<li>';
        $this->num_tag_close = '</li>';
        $this->next_tag_open = '<li>';
        $this->next_tag_close = '</li>';
        $this->last_tag_open = '<li class="last">';
        $this->last_tag_close = '</li>';
//		$this->show_first_last	=	'no';
//		$this->prev_link		=	'‹';
//		$this->next_link		=	'›';
        $this->title_link = 'Trang';

        $this->base_url = preg_replace('@' . $this->page_string . '=[0-9]+@is', '', $this->base_url);
        $this->base_url = str_replace(array('&&', '?&'), array('&', '?'), $this->base_url);
        $this->base_url = preg_replace('@(&|\?)$@is', '', $this->base_url);

        $pagination = '';
        $total = ceil($this->total_rows / $this->per_page);
        if ($total > 1) {
            $first = 0;
            $end = 0;
            if ($this->cur_page != 1) {
                $first = $this->cur_page - 3;
                if ($first <= 0) {
                    $first = 1;
                    $end = 4 - $this->cur_page;
                }
                $end = $end + $this->cur_page + 3;
                if ($end > $total) {
                    $end = $total;
                    $first = $total - 6;
                    if ($first <= 0) {
                        $first = 1;
                    }
                }
            } else {
                $first = 1;
                $end = 7;
                if ($end > $total) {
                    $end = $total;
                }
            }

            $pagination.= $this->full_tag_open;

            if ($this->cur_page > 1) {
                if ($this->show_first_last == 'yes') {
                    $pagination .= $this->first_tag_open;
                    $pagination .= "<a class='" . $this->first_class . "' href='" . $this->base_url . "" . "'>" . $this->first_link . "</a>";
                    $pagination .= $this->first_tag_close;
                }

                $pagination .= $this->prev_tag_open;
                if (($this->cur_page - 1) == 1)
                    $pagination .= "<a class='" . $this->prev_class . "' href='" . $this->base_url . "" . "'>" . $this->prev_link . "</a>" . $this->num_space;
                else
                    $pagination .= "<a class='" . $this->prev_class . "' href='" . ((strpos($this->base_url, '?') == false) ? $this->base_url . "?" . $this->page_string . "=" . ($this->cur_page - 1) : $this->base_url . "&" . $this->page_string . "=" . ($this->cur_page - 1)) . "'>" . $this->prev_link . "</a>" . $this->num_space;
                $pagination .= $this->prev_tag_close;
            }
            else {
                if ($this->show_first_last == 'yes') {
                    $pagination .= $this->next_tag_open;
                    $pagination .= '<strong class="disablelink">' . $this->first_link . '</strong>';
                    $pagination .= $this->next_tag_close;
                }

                //if($this->show_first_last == 'yes'){
                $pagination .= $this->last_tag_open;
                $pagination .= '<a class="disablelink">' . $this->prev_link . '</a>';
                $pagination .= $this->last_tag_close;
                //}
            }

            if ($this->show_num == 'yes') {
                $j = 0;
                for ($i = $first; $i <= $end; $i++) {
                    $j++;
                    if ($i == $this->cur_page) {
                        $pagination .= $this->cur_tag_open;
                        $pagination .= '<span class="' . $this->cur_class . '">' . $i . '</span>' . $this->num_space;
                        $pagination .= $this->cur_tag_close;
                    } else {
                        $pagination .= $this->num_tag_open;
                        if ($i == 1)
                            $pagination .= "<a title='" . $this->title_link . ' ' . $i . "' class='" . $this->num_class . (($j == 7) ? ' end' : '') . "' href='" . $this->base_url . "" . "'>" . $i . "</a>" . $this->num_space;
                        else
                            $pagination .= "<a title='" . $this->title_link . ' ' . $i . "' class='" . $this->num_class . (($j == 7) ? ' end' : '') . "' href='" . ((strpos($this->base_url, '?') == false) ? $this->base_url . "?" . $this->page_string . "=" . $i : $this->base_url . "&" . $this->page_string . "=" . $i) . "'>" . $i . "</a>" . $this->num_space;
                        $pagination .= $this->num_tag_close;
                    }
                }
            }else {
                if ($this->cur_page > 1 && $this->cur_page < $total)
                    $pagination .= '|';
            }

            if ($this->show_total == 'yes')
                $pagination .= $this->total_tag_open . 'of ' . $total . $this->total_tag_close;

            if ($this->cur_page < $total) {
                $pagination.= $this->next_tag_open;
                $pagination.= "<a class='" . $this->next_class . "' href='" . ((strpos($this->base_url, '?') == false) ? $this->base_url . "?" . $this->page_string . "=" . ($this->cur_page + 1) : $this->base_url . "&" . $this->page_string . "=" . ($this->cur_page + 1)) . "'>" . $this->next_link . "</a>";
                $pagination.= $this->next_tag_close;

                if ($this->show_first_last == 'yes') {
                    $pagination.= $this->last_tag_open;
                    $pagination.= "<a class='" . $this->last_class . "' href='" . ((strpos($this->base_url, "?") == false) ? $this->base_url . "?" . $this->page_string . "=" . $total : $this->base_url . "&" . $this->page_string . "=" . $total) . "'>" . $this->last_link . "</a>";
                    $pagination.= $this->last_tag_close;
                }
            } else {
                $pagination .= $this->next_tag_open;
                $pagination .= '<a class="disablelink">' . $this->next_link . '</a>';
                $pagination .= $this->next_tag_close;

                if ($this->show_first_last == 'yes') {
                    $pagination .= $this->last_tag_open;
                    $pagination .= '<strong class="disablelink">' . $this->last_link . '</strong>';
                    $pagination .= $this->last_tag_close;
                }
            }


            $pagination.= $this->full_tag_close;
        }
        return $pagination;
    }

    function display_ul_li_router($url_alias) {
        $this->full_tag_open = '<ul class="item-list">';
        $this->full_tag_close = '</ul>';
        $this->first_tag_open = '<li class="first">';
        $this->first_tag_close = '</li>';
        $this->prev_tag_open = '<li>';
        $this->prev_tag_close = '</li>';
        $this->cur_tag_open = '<li class="current">';
        $this->cur_tag_close = '</li>';
        $this->num_tag_open = '<li>';
        $this->num_tag_close = '</li>';
        $this->next_tag_open = '<li>';
        $this->next_tag_close = '</li>';
        $this->last_tag_open = '<li class="last">';
        $this->last_tag_close = '</li>';
//		$this->show_first_last	=	'no';
//		$this->prev_link		=	'‹';
//		$this->next_link		=	'›';
        $this->title_link = 'Trang';
        $this->page_string = '-trang';

        if (preg_match('/(' . $this->page_string . '-[0-9]+).html/is', $this->base_url, $tmp))
            $this->base_url = str_replace($tmp[1], '', $this->base_url);
        $this->base_url = str_replace(array('&&', '?&'), array('&', '?'), $this->base_url);
        $this->base_url = preg_replace('@(&|\?)$@is', '', $this->base_url);

        $request = '';
        if (preg_match('/.*?.html\?(.*)/is', $this->base_url, $tmp))
            $request = $tmp[1];

        $pagination = '';
        $total = ceil($this->total_rows / $this->per_page);
        if ($total > 1) {
            $first = 0;
            $end = 0;
            if ($this->cur_page != 1) {
                $first = $this->cur_page - 3;
                if ($first <= 0) {
                    $first = 1;
                    $end = 4 - $this->cur_page;
                }
                $end = $end + $this->cur_page + 3;
                if ($end > $total) {
                    $end = $total;
                    $first = $total - 6;
                    if ($first <= 0) {
                        $first = 1;
                    }
                }
            } else {
                $first = 1;
                $end = 7;
                if ($end > $total) {
                    $end = $total;
                }
            }

            $pagination.= $this->full_tag_open;

            if ($this->cur_page > 1) {
                if ($this->show_first_last == 'yes') {
                    $pagination .= $this->first_tag_open;
                    $pagination .= "<a class='" . $this->first_class . "' href='" . $this->base_url . "" . "'>" . $this->first_link . "</a>";
                    $pagination .= $this->first_tag_close;
                }

                $pagination .= $this->prev_tag_open;
                if (($this->cur_page - 1) == 1)
                    $pagination .= "<a class='" . $this->prev_class . "' href='" . $this->base_url . "" . "'>" . $this->prev_link . "</a>" . $this->num_space;
                else
                    $pagination .= "<a class='" . $this->prev_class . "' href='" . (($request == '') ? $url_alias . $this->page_string . "-" . ($this->cur_page - 1) . '.html' : $url_alias . $this->page_string . "-" . ($this->cur_page - 1) . '.html?' . $request) . "'>" . $this->prev_link . "</a>" . $this->num_space;
                $pagination .= $this->prev_tag_close;
            }
            else {
                if ($this->show_first_last == 'yes') {
                    $pagination .= $this->next_tag_open;
                    $pagination .= '<strong class="disablelink">' . $this->first_link . '</strong>';
                    $pagination .= $this->next_tag_close;
                }

                //if($this->show_first_last == 'yes'){
                $pagination .= $this->last_tag_open;
                $pagination .= '<a class="disablelink">' . $this->prev_link . '</a>';
                $pagination .= $this->last_tag_close;
                //}
            }

            if ($this->show_num == 'yes') {
                $j = 0;
                for ($i = $first; $i <= $end; $i++) {
                    $j++;
                    if ($i == $this->cur_page) {
                        $pagination .= $this->cur_tag_open;
                        $pagination .= '<span class="' . $this->cur_class . '">' . $i . '</span>' . $this->num_space;
                        $pagination .= $this->cur_tag_close;
                    } else {
                        $pagination .= $this->num_tag_open;
                        if ($i == 1)
                            $pagination .= "<a title='" . $this->title_link . ' ' . $i . "' class='" . $this->num_class . (($j == 7) ? ' end' : '') . "' href='" . $this->base_url . "" . "'>" . $i . "</a>" . $this->num_space;
                        else
                            $pagination .= "<a title='" . $this->title_link . ' ' . $i . "' class='" . $this->num_class . (($j == 7) ? ' end' : '') . "' href='" . (($request == '') ? $url_alias . $this->page_string . "-" . $i . '.html' : $url_alias . $this->page_string . "-" . $i . '.html?' . $request) . "'>" . $i . "</a>" . $this->num_space;
                        $pagination .= $this->num_tag_close;
                    }
                }
            }else {
                if ($this->cur_page > 1 && $this->cur_page < $total)
                    $pagination .= '|';
            }

            if ($this->show_total == 'yes')
                $pagination .= $this->total_tag_open . 'of ' . $total . $this->total_tag_close;

            if ($this->cur_page < $total) {
                $pagination.= $this->next_tag_open;
                $pagination.= "<a class='" . $this->next_class . "' href='" . (($request == '') ? $url_alias . $this->page_string . "-" . ($this->cur_page + 1) . '.html' : $url_alias . $this->page_string . "-" . ($this->cur_page + 1) . '.html?' . $request) . "'>" . $this->next_link . "</a>";
                $pagination.= $this->next_tag_close;

                if ($this->show_first_last == 'yes') {
                    $pagination.= $this->last_tag_open;
                    $pagination.= "<a class='" . $this->last_class . "' href='" . (($request == '') ? $url_alias . $this->page_string . "-" . $total . '.html' : $url_alias . $this->page_string . "-" . $total . '.html?' . $request) . "'>" . $this->last_link . "</a>";
                    $pagination.= $this->last_tag_close;
                }
            } else {
                $pagination .= $this->next_tag_open;
                $pagination .= '<a class="disablelink">' . $this->next_link . '</a>';
                $pagination .= $this->next_tag_close;

                if ($this->show_first_last == 'yes') {
                    $pagination .= $this->last_tag_open;
                    $pagination .= '<strong class="disablelink">' . $this->last_link . '</strong>';
                    $pagination .= $this->last_tag_close;
                }
            }


            $pagination.= $this->full_tag_close;
        }
        return $pagination;
    }

    function display() {
        $pagination = '';
        $total = ceil($this->total_rows / $this->per_page);
        if ($total > 1) {
            $first = 0;
            $end = 0;
            if ($this->cur_page != 1) {
                $first = $this->cur_page - 3;
                if ($first <= 0) {
                    $first = 1;
                    $end = 4 - $this->cur_page;
                }
                $end = $end + $this->cur_page + 3;
                if ($end > $total) {
                    $end = $total;
                    $first = $total - 6;
                    if ($first <= 0) {
                        $first = 1;
                    }
                }
            } else {
                $first = 1;
                $end = 7;
                if ($end > $total) {
                    $end = $total;
                }
            }

            $pagination.= $this->full_tag_open;

            if ($this->cur_page > 1) {
                if ($this->show_first_last == 'yes') {
                    $pagination .= $this->first_tag_open;
                    $pagination .= "<a href='" . $this->base_url . "/" . "'>" . $this->first_link . "</a>";
                    $pagination .= $this->first_tag_close;
                }

                $pagination .= $this->prev_tag_open;
                if (($this->cur_page - 1) == 1)
                    $pagination .= "<a class='" . $this->prev_class . "' href='" . $this->base_url . "/" . "'>" . $this->prev_link . "</a>" . $this->num_space;
                else
                    $pagination .= "<a class='" . $this->prev_class . "' href='" . $this->base_url . "/" . ($this->cur_page - 1) . "/'>" . $this->prev_link . "</a>" . $this->num_space;
                $pagination .= $this->prev_tag_close;
            }
            else {
                if ($this->show_first_last == 'yes') {
                    $pagination .= $this->first_tag_open;
                    $pagination .= "<a href='javascript:;'>" . $this->first_link . "</a>";
                    $pagination .= $this->first_tag_close;
                }

                $pagination .= $this->prev_tag_open;
                if (($this->cur_page - 1) == 1)
                    $pagination .= "<a class='" . $this->prev_class . "' href='javascript:;'>" . $this->prev_link . "</a>" . $this->num_space;
                else
                    $pagination .= "<a class='" . $this->prev_class . "' href='javascript:;'>" . $this->prev_link . "</a>" . $this->num_space;
                $pagination .= $this->prev_tag_close;
            }

            if ($this->show_num == 'yes') {
                $j = 0;
                for ($i = $first; $i <= $end; $i++) {
                    $j++;
                    if ($i == $this->cur_page) {
                        $pagination .= $this->cur_tag_open;
                        $pagination .= '<a class="' . $this->cur_class . '">' . $i . '</a>' . $this->num_space;
                        $pagination .= $this->cur_tag_close;
                    } else {
                        $pagination .= $this->num_tag_open;
                        if ($i == 1)
                            $pagination .= "<a title='" . $this->title_link . ' ' . $i . "' class='" . $this->num_class . (($j == 7) ? ' end' : '') . "' href='" . $this->base_url . "/" . "'>" . $i . "</a>" . $this->num_space;
                        else
                            $pagination .= "<a title='" . $this->title_link . ' ' . $i . "' class='" . $this->num_class . (($j == 7) ? ' end' : '') . "' href='" . $this->base_url . "/" . $i . "/'>" . $i . "</a>" . $this->num_space;
                        $pagination .= $this->num_tag_close;
                    }
                }
            }else {
                if ($this->cur_page > 1 && $this->cur_page < $total)
                    $pagination .= $this->num_space;
            }

            if ($this->show_total == 'yes')
                $pagination .= $this->total_tag_open . 'of ' . $total . $this->total_tag_close;

            if ($this->cur_page < $total) {
                $pagination.= $this->next_tag_open;
                $pagination.= "<a class='" . $this->next_class . "' href='" . $this->base_url . "/" . ($this->cur_page + 1) . "/'>" . $this->next_link . "</a>";
                $pagination.= $this->next_tag_close;

                if ($this->show_first_last == 'yes') {
                    $pagination.= $this->last_tag_open;
                    $pagination.= "<a href='" . $this->base_url . "/" . $total . "/'>" . $this->last_link . "</a>";
                    $pagination.= $this->last_tag_close;
                }
            } else {
                $pagination.= $this->next_tag_open;
                $pagination.= "<a class='" . $this->next_class . "' href='javascript:;'>" . $this->next_link . "</a>";
                $pagination.= $this->next_tag_close;

                if ($this->show_first_last == 'yes') {
                    $pagination.= $this->last_tag_open;
                    $pagination.= "<a href='javascript:;'>" . $this->last_link . "</a>";
                    $pagination.= $this->last_tag_close;
                }
            }


            $pagination.= $this->full_tag_close;
        }
        return $pagination;
    }

    function display_query_string() {
        $this->base_url = preg_replace('@' . $this->page_string . '=[0-9]+@is', '', $this->base_url);
        $this->base_url = str_replace(array('&&', '?&'), array('&', '?'), $this->base_url);
        $this->base_url = preg_replace('@(&|\?)$@is', '', $this->base_url);

        $pagination = '';
        $total = ceil($this->total_rows / $this->per_page);
        if ($total > 1) {
            $first = 0;
            $end = 0;
            if ($this->cur_page != 1) {
                $first = $this->cur_page - 3;
                if ($first <= 0) {
                    $first = 1;
                    $end = 4 - $this->cur_page;
                }
                $end = $end + $this->cur_page + 3;
                if ($end > $total) {
                    $end = $total;
                    $first = $total - 6;
                    if ($first <= 0) {
                        $first = 1;
                    }
                }
            } else {
                $first = 1;
                $end = 7;
                if ($end > $total) {
                    $end = $total;
                }
            }

            $pagination.= $this->full_tag_open;

            if ($this->cur_page > 1) {
                if ($this->show_first_last == 'yes') {
                    $pagination .= $this->first_tag_open;
                    $pagination .= "<a class='" . $this->first_class . "' href='" . $this->base_url . "" . "'>" . $this->first_link . "</a>";
                    $pagination .= $this->first_tag_close;
                }

                $pagination .= $this->prev_tag_open;
                if (($this->cur_page - 1) == 1)
                    $pagination .= "<a class='" . $this->prev_class . "' href='" . $this->base_url . "" . "'>" . $this->prev_link . "</a>" . $this->num_space;
                else
                    $pagination .= "<a class='" . $this->prev_class . "' href='" . ((strpos($this->base_url, '?') == false) ? $this->base_url . "?" . $this->page_string . "=" . ($this->cur_page - 1) : $this->base_url . "&" . $this->page_string . "=" . ($this->cur_page - 1)) . "'>" . $this->prev_link . "</a>" . $this->num_space;
                $pagination .= $this->prev_tag_close;
            }
            else {
                $pagination .= $this->next_tag_open;
                $pagination .= '<a class="disablelink">' . $this->first_link . '</a>';
                $pagination .= $this->next_tag_close;

                if ($this->show_first_last == 'yes') {
                    $pagination .= $this->last_tag_open;
                    $pagination .= '<a class="disablelink">' . $this->prev_link . '</a>';
                    $pagination .= $this->last_tag_close;
                }
            }

            if ($this->show_num == 'yes') {
                $j = 0;
                for ($i = $first; $i <= $end; $i++) {
                    $j++;
                    if ($i == $this->cur_page) {
                        $pagination .= $this->cur_tag_open;
                        $pagination .= '<a class="' . $this->cur_class . '">' . $i . '</a>' . $this->num_space;
                        $pagination .= $this->cur_tag_close;
                    } else {
                        $pagination .= $this->num_tag_open;
                        if ($i == 1)
                            $pagination .= "<a title='" . $this->title_link . ' ' . $i . "' class='" . $this->num_class . (($j == 7) ? ' end' : '') . "' href='" . $this->base_url . "" . "'>" . $i . "</a>" . $this->num_space;
                        else
                            $pagination .= "<a title='" . $this->title_link . ' ' . $i . "' class='" . $this->num_class . (($j == 7) ? ' end' : '') . "' href='" . ((strpos($this->base_url, '?') == false) ? $this->base_url . "?" . $this->page_string . "=" . $i : $this->base_url . "&" . $this->page_string . "=" . $i) . "'>" . $i . "</a>" . $this->num_space;
                        $pagination .= $this->num_tag_close;
                    }
                }
            }else {
                if ($this->cur_page > 1 && $this->cur_page < $total)
                    $pagination .= '|';
            }

            if ($this->show_total == 'yes')
                $pagination .= $this->total_tag_open . 'of ' . $total . $this->total_tag_close;

            if ($this->cur_page < $total) {
                $pagination.= $this->next_tag_open;
                $pagination.= "<a class='" . $this->next_class . "' href='" . ((strpos($this->base_url, '?') == false) ? $this->base_url . "?" . $this->page_string . "=" . ($this->cur_page + 1) : $this->base_url . "&" . $this->page_string . "=" . ($this->cur_page + 1)) . "'>" . $this->next_link . "</a>";
                $pagination.= $this->next_tag_close;

                if ($this->show_first_last == 'yes') {
                    $pagination.= $this->last_tag_open;
                    $pagination.= "<a class='" . $this->last_class . "' href='" . ((strpos($this->base_url, "?") == false) ? $this->base_url . "?" . $this->page_string . "=" . $total : $this->base_url . "&" . $this->page_string . "=" . $total) . "'>" . $this->last_link . "</a>";
                    $pagination.= $this->last_tag_close;
                }
            } else {
                $pagination .= $this->next_tag_open;
                $pagination .= '<a class="disablelink">' . $this->next_link . '</a>';
                $pagination .= $this->next_tag_close;

                if ($this->show_first_last == 'yes') {
                    $pagination .= $this->last_tag_open;
                    $pagination .= '<a class="disablelink">' . $this->last_link . '</a>';
                    $pagination .= $this->last_tag_close;
                }
            }


            $pagination.= $this->full_tag_close;
        }
        return $pagination;
    }

    function display_frame_query_string() {
        $this->base_url = preg_replace('@' . $this->page_string . '=[0-9]+@is', '', $this->base_url);
        $this->base_url = str_replace(array('&&', '?&'), array('&', '?'), $this->base_url);
        $this->base_url = preg_replace('@(&|\?)$@is', '', $this->base_url);

        $pagination = '';
        $total = ceil($this->total_rows / $this->per_page);
        if ($total > 1) {
            $first = 0;
            $end = 0;
            if ($this->cur_page != 1) {
                $first = $this->cur_page - 3;
                if ($first <= 0) {
                    $first = 1;
                    $end = 4 - $this->cur_page;
                }
                $end = $end + $this->cur_page + 3;
                if ($end > $total) {
                    $end = $total;
                    $first = $total - 6;
                    if ($first <= 0) {
                        $first = 1;
                    }
                }
            } else {
                $first = 1;
                $end = 7;
                if ($end > $total) {
                    $end = $total;
                }
            }

            $pagination.= $this->full_tag_open;

            if ($this->cur_page > 1) {
                if ($this->show_first_last == 'yes') {
                    $pagination .= $this->first_tag_open;
                    $pagination .= "<a class='" . $this->first_class . "' onclick=\"open_form('" . $this->base_url . "" . "')\">" . $this->first_link . "</a>";
                    $pagination .= $this->first_tag_close;
                }

                $pagination .= $this->prev_tag_open;
                if (($this->cur_page - 1) == 1)
                    $pagination .= "<a class='" . $this->prev_class . "' onclick=\"open_form('" . $this->base_url . "" . "')\">" . $this->prev_link . "</a>" . $this->num_space;
                else
                    $pagination .= "<a class='" . $this->prev_class . "' onclick=\"open_form('" . ((strpos($this->base_url, '?') == false) ? $this->base_url . "?" . $this->page_string . "=" . ($this->cur_page - 1) : $this->base_url . "&" . $this->page_string . "=" . ($this->cur_page - 1)) . "')\">" . $this->prev_link . "</a>" . $this->num_space;
                $pagination .= $this->prev_tag_close;
            }
            else {
                $pagination .= $this->next_tag_open;
                $pagination .= '<a class="disablelink">' . $this->first_link . '</a>';
                $pagination .= $this->next_tag_close;

                if ($this->show_first_last == 'yes') {
                    $pagination .= $this->last_tag_open;
                    $pagination .= '<a class="disablelink">' . $this->prev_link . '</a>';
                    $pagination .= $this->last_tag_close;
                }
            }

            if ($this->show_num == 'yes') {
                $j = 0;
                for ($i = $first; $i <= $end; $i++) {
                    $j++;
                    if ($i == $this->cur_page) {
                        $pagination .= $this->cur_tag_open;
                        $pagination .= '<a class="' . $this->cur_class . '">' . $i . '</a>' . $this->num_space;
                        $pagination .= $this->cur_tag_close;
                    } else {
                        $pagination .= $this->num_tag_open;
                        if ($i == 1)
                            $pagination .= "<a title='" . $this->title_link . ' ' . $i . "' class='" . $this->num_class . (($j == 7) ? ' end' : '') . "' onclick=\"open_form('" . $this->base_url . "" . "')\">" . $i . "</a>" . $this->num_space;
                        else
                            $pagination .= "<a title='" . $this->title_link . ' ' . $i . "' class='" . $this->num_class . (($j == 7) ? ' end' : '') . "' onclick=\"open_form('" . ((strpos($this->base_url, '?') == false) ? $this->base_url . "?" . $this->page_string . "=" . $i : $this->base_url . "&" . $this->page_string . "=" . $i) . "')\">" . $i . "</a>" . $this->num_space;
                        $pagination .= $this->num_tag_close;
                    }
                }
            }else {
                if ($this->cur_page > 1 && $this->cur_page < $total)
                    $pagination .= '|';
            }

            if ($this->show_total == 'yes')
                $pagination .= $this->total_tag_open . 'of ' . $total . $this->total_tag_close;

            if ($this->cur_page < $total) {
                $pagination.= $this->next_tag_open;
                $pagination.= "<a class='" . $this->next_class . "' onclick=\"open_form('" . ((strpos($this->base_url, '?') == false) ? $this->base_url . "?" . $this->page_string . "=" . ($this->cur_page + 1) : $this->base_url . "&" . $this->page_string . "=" . ($this->cur_page + 1)) . "')\">" . $this->next_link . "</a>";
                $pagination.= $this->next_tag_close;

                if ($this->show_first_last == 'yes') {
                    $pagination.= $this->last_tag_open;
                    $pagination.= "<a class='" . $this->last_class . "' onclick=\"open_form('" . ((strpos($this->base_url, "?") == false) ? $this->base_url . "?" . $this->page_string . "=" . $total : $this->base_url . "&" . $this->page_string . "=" . $total) . "')\">" . $this->last_link . "</a>";
                    $pagination.= $this->last_tag_close;
                }
            } else {
                $pagination .= $this->next_tag_open;
                $pagination .= '<a class="disablelink">' . $this->next_link . '</a>';
                $pagination .= $this->next_tag_close;

                if ($this->show_first_last == 'yes') {
                    $pagination .= $this->last_tag_open;
                    $pagination .= '<a class="disablelink">' . $this->last_link . '</a>';
                    $pagination .= $this->last_tag_close;
                }
            }


            $pagination.= $this->full_tag_close;
        }
        return $pagination;
    }

    function non_ajax() {
        $pagination = '';
        $total = $this->total_rows;
        if ($total > 1) {
            $first = 0;
            $end = 0;
            if ($this->cur_page != 1) {
                $first = $this->cur_page - 3;
                if ($first <= 0) {
                    $first = 1;
                    $end = 4 - $this->cur_page;
                }
                $end = $end + $this->cur_page + 3;
                if ($end > $this->total_rows) {
                    $end = $this->total_rows;
                    $first = $this->total_rows - 6;
                    if ($first <= 0) {
                        $first = 1;
                    }
                }
            } else {
                $first = 1;
                $end = 7;
                if ($end > $this->total_rows) {
                    $end = $this->total_rows;
                }
            }

            $pagination.= $this->full_tag_open;

            if ($this->cur_page > 1) {
                if ($this->show_first_last == 'yes') {
                    $pagination .= $this->first_tag_open;
                    $pagination .= "<a href='" . $this->base_url . "" . "'>" . $this->first_link . "</a>";
                    $pagination .= $this->first_tag_close;
                }

                $pagination .= $this->prev_tag_open;
                if (($this->cur_page - 1) == 1)
                    $pagination .= "<a class='" . $this->prev_class . "' href='" . $this->base_url . "" . "'>" . $this->prev_link . "</a>";
                else
                    $pagination .= "<a class='" . $this->prev_class . "' href='" . $this->base_url . "" . ($this->cur_page - 1) . "/'>" . $this->prev_link . "</a>";
                $pagination .= $this->prev_tag_close;
            }

            if ($this->show_num == 'yes') {
                $j = 0;
                for ($i = $first; $i <= $end; $i++) {
                    $j++;
                    if ($i == $this->cur_page) {
                        $pagination .= $this->cur_tag_open;
                        $pagination .= '<a class="' . $this->cur_class . '">' . $i . '</a>';
                        $pagination .= $this->cur_tag_close;
                    } else {
                        $pagination .= $this->num_tag_open;
                        if ($i == 1)
                            $pagination .= "<a title='" . $this->title_link . ' ' . $i . "' class='" . $this->num_class . (($j == 7) ? ' end' : '') . "' href='" . $this->base_url . "" . "'>" . $i . "</a>";
                        else
                            $pagination .= "<a title='" . $this->title_link . ' ' . $i . "' class='" . $this->num_class . (($j == 7) ? ' end' : '') . "' href='" . $this->base_url . "" . $i . "/'>" . $i . "</a>";
                        $pagination .= $this->num_tag_close;
                    }
                }
            }else {
                if ($this->cur_page > 1 && $this->cur_page < $this->total_rows)
                    $pagination .= '|';
            }

            if ($this->show_total == 'yes')
                $pagination .= $this->total_tag_open . 'of ' . $this->total_rows . $this->total_tag_close;

            if ($this->cur_page < $this->total_rows) {
                $pagination.= $this->next_tag_open;
                $pagination.= "<a class='" . $this->next_class . "' href='" . $this->base_url . "" . ($this->cur_page + 1) . "/'>" . $this->next_link . "</a>";
                $pagination.= $this->next_tag_close;

                if ($this->show_first_last == 'yes') {
                    $pagination.= $this->last_tag_open;
                    $pagination.= "<a href='" . $this->base_url . "" . $this->total_rows . "/'>" . $this->last_link . "</a>";
                    $pagination.= $this->last_tag_close;
                }
            }


            $pagination.= $this->full_tag_close;
        }
        return $pagination;
    }

}