//
//  MyOrdersController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 29/12/22.
//

import UIKit

class MyOrdersController: UIViewController {

    // MARK: IBOUTLET
    @IBOutlet weak var myOrderstableView: UITableView!
    @IBOutlet weak var searchtextField: UITextField!
    @IBOutlet weak var titleLabel: UILabel!
    // MARK: - VARIABLES
    var myOrderViewModel: MyOrderViewModel
    init(viewModel: MyOrderViewModel){
        self.myOrderViewModel = viewModel
        super.init(nibName: nil, bundle: nil)
    }
    
    required init?(coder:NSCoder) {
        self.myOrderViewModel = MyOrderViewModel()
        super.init(coder: coder)
    }
    // MARK: ViewDidLoad--
    override func viewDidLoad() {
        super.viewDidLoad()
        self.setCustomUI()
        // Do any additional setup after loading the view.
    }
    
}
