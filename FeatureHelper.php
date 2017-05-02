<?php
class FeatureHelper
{
    public static function getProductFeatureList($langId, $productId)
    {
        $sql = 'SELECT fl.name, fvl.value FROM ' . _DB_PREFIX_ . 'feature_product fp
                    INNER JOIN ' . _DB_PREFIX_ . 'feature_lang fl  ON fl.id_feature = fp.id_feature
                    INNER JOIN ' . _DB_PREFIX_ . 'feature_value_lang fvl ON fvl.id_feature_value = fp.id_feature_value
                    WHERE fl.id_lang = ' . (int) $langId . ' AND fvl.id_lang = ' . (int) $langId .
            ' AND fp.id_product = ' . (int) $productId;

        return Db::getInstance()->executeS($sql);
    }

    public static function getProductsFeatureList($langId)
    {
        $sql = 'SELECT fl.name, fvl.value, fp.id_product FROM ' . _DB_PREFIX_ . 'feature_product fp
                INNER JOIN ' . _DB_PREFIX_ . 'feature_lang fl  ON fl.id_feature = fp.id_feature
                INNER JOIN ' . _DB_PREFIX_ . 'feature_value_lang fvl ON fvl.id_feature_value = fp.id_feature_value
                WHERE fl.id_lang = ' . (int) $langId . ' AND fvl.id_lang = ' . (int) $langId;

        $data =  Db::getInstance()->executeS($sql);

        $products = [];
        foreach ($data as $item) {
            $products[$item['id_product']][] = [
                'name' => $item['name'],
                'value' => $item['value']
            ];
        }

        ksort($products);

        return $products;
    }
}
