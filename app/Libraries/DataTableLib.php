<?php

namespace App\Libraries;

use Illuminate\Support\Facades\DB;

/**
 * Description of dataTableLib
 *
 */
class DataTableLib {

    /**
     * Function used to get data from databse in json format for data table
     * @param Array $request        All GET parameter of request
     * @param String $sTable        Table name and join string
     * @param Array $aColumns       array of column name to select
     * @param Array $aColumnsSE     array of column name use for search
     * @param Array $aColumnsOR     array of column name use for order by
     * @param Array $aColumnsD      array of column name which display on datatable
     * @param String $where         String of where like user_type = 1 AND is_active = 1
     * @param String $sGroupBy      String of Group by like Group By user_name
     * @return String json string
     */
    public function getData($request, $sTable, $aColumns, $aColumnsSE, $aColumnsOR, $aColumnsD, $where = null, $sGroupBy = null, $unionCount = 0, $aColumns2) {

        /*         * * Paging  ** */
        $sLimit = "";
        if (isset($request['iDisplayStart']) && $request['iDisplayLength'] != '-1') {
            $sLimit = " LIMIT " . intval($request['iDisplayStart']) . ", " .
                    intval($request['iDisplayLength']);
        }

        /*         * * Ordering  ** */
        $sOrder = "";
        if (isset($request['iSortCol_0'])) {
            $sOrder = " ORDER BY  ";
            for ($i = 0; $i < intval($request['iSortingCols']); $i++) {
                if ($request['bSortable_' . intval($request['iSortCol_' . $i])] == "true") {
                    $sOrder .= $aColumnsOR[intval($request['iSortCol_' . $i])] . " " .
                            ($request['sSortDir_' . $i] === 'asc' ? 'asc' : 'desc') . ", ";
                }
            }

            $sOrder = substr_replace($sOrder, "", -2);
            if ($sOrder == " ORDER BY") {
                $sOrder = "";
            }
        }

        /*
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */
        $sWhere = "";
        if (isset($request['sSearch']) && $request['sSearch'] != "") {
            $sWhere = "WHERE (";
            for ($i = 0; $i < count($aColumnsSE); $i++) {
                $sWhere .= $aColumnsSE[$i] . " LIKE '%" . $request['sSearch'] . "%' OR ";
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ')';
        }

        /* Individual column filtering */
        for ($i = 0; $i < count($aColumns); $i++) {
            if (isset($request['bSearchable_' . $i]) && $request['bSearchable_' . $i] == "true" && $request['sSearch_' . $i] != '') {
                if ($sWhere == "") {
                    $sWhere = "WHERE ";
                } else {
                    $sWhere .= " AND ";
                }
                $sWhere .= $aColumns[$i] . " LIKE '%" . mysql_real_escape_string($request['sSearch_' . $i]) . "%' ";
            }
        }

        if (null != $where) {
            if ($sWhere == '') {
                $where = ' WHERE ' . $where;
            } else {
                $where = ' AND ' . $where;
            }
        }

        /** SQL queries * Get data to display    */
        $sQuery = '';
        if ($unionCount > 0) {
            $sQuery .= "(SELECT " . str_replace(" , ", " ", implode(", ", $aColumns)) . " FROM " . $sTable . " ".$sWhere." ".$where.") UNION ALL ";
            $sQuery .= "(SELECT " . str_replace(" , ", " ", implode(", ", $aColumns2)) . " FROM " . $sTable . " ".$sWhere." ".$where.")";
        } else {
            $sQuery .= "SELECT " . str_replace(" , ", " ", implode(", ", $aColumns)) . " FROM " . $sTable." ".$sWhere." ".$where;
        }

        $sQuery .=  $sGroupBy . $sOrder . $sLimit;
        $rResult = DB::select($sQuery);

        /*
         * Total data set length. changed by Firoj
         */
        $queryForTotalCount = '';
        if ($unionCount > 0) {
            $queryForTotalCount .= "(SELECT " . str_replace(" , ", " ", implode(", ", $aColumns)) . " FROM " . $sTable . " ".$sWhere." ".$where.") UNION ALL" ;
            $queryForTotalCount .= "(SELECT " . str_replace(" , ", " ", implode(", ", $aColumns2)) . " FROM " . $sTable . " ".$sWhere." ".$where.")";
        } else {
            $queryForTotalCount .= "SELECT " . str_replace(" , ", " ", implode(", ", $aColumns)) . " FROM " . $sTable." ".$sWhere." ".$where;
        }

        $queryForTotalCount .= $sGroupBy . $sOrder;
        $TotalResult = DB::select($queryForTotalCount);
        $iTotal = count($TotalResult);

//        $queryForTotalCount = "SELECT " . str_replace(" , ", " ", implode(", ", $aColumns)) . "
//		FROM $sTable
//		$sWhere
//                $where
//                $sGroupBy
//		$sOrder
//		";
//        $TotalResult = DB::select($queryForTotalCount);
//        $iTotal = count($TotalResult);

        /** Output ** */
        $output = array(
            "sEcho" => intval($request['sEcho']),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iTotal,
            "aaData" => array()
        );

        foreach ($rResult as $aRow) {
            $row = array();
            for ($i = 0; $i < count($aColumnsD); $i++) {
                $x=$aColumnsD[$i];
                $row[] = $aRow->$x;
            }
            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }

}
