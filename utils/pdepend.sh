#!/bin/sh
ROOT_PATH="$(dirname "$(pwd)")"
$ROOT_PATH/vendor/pdepend/pdepend/src/bin/pdepend --summary-xml=$ROOT_PATH/docs/pdepend/summary.xml --jdepend-chart=$ROOT_PATH/docs/pdepend/jdepend-chart.svg --jdepend-xml=$ROOT_PATH/docs/pdepend/jdepend.xml --overview-pyramid=$ROOT_PATH/docs/pdepend/overview.svg $ROOT_PATH/front
