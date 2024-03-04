//
//  TicketDetailsViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 21/03/23.
//

import UIKit

class TicketDetailsViewController: UIViewController {
    
    // MARK: IBOutlets--
    @IBOutlet weak var previousButton: UIButton!
    @IBOutlet weak var collectionView: UICollectionView!
    @IBOutlet weak var lblCount: UILabel!
    @IBOutlet weak var nextButton: UIButton!
    // MARK: - Variable initializer
    lazy var ticketViewModel:TicketDetailViewModel = {
        var ticketViewModel = TicketDetailViewModel()
        return ticketViewModel
    }()
    var ticketModel : TicketDetailModel?
    var currentPage = 1
    // MARK: - viewDidLoad
    override func viewDidLoad() {
        super.viewDidLoad()
        
        // Do any additional setup after loading the view.
        collectionView.delegate = self
        collectionView.dataSource = self
       
    }
    override func viewWillAppear(_ animated: Bool) {
        getTicketDetails()
        collectionView.reloadData()
    }
    // MARK: - Create function for calling get QR-Code Api
    func getTicketDetails(){
        ticketViewModel.callTicketDetailApi(id: ticketViewModel.id) {[weak self] data, isSuccess in
            if isSuccess == true{
                self?.ticketModel = data
                self?.lblCount.text = ("\(self?.currentPage ?? 0) of \(self?.ticketModel?.data?.count ?? 0)")
                self?.collectionView.reloadData()
            }else{
                self?.showSimpleAlert(message: data.message ?? DefaultValue.errorMsg.rawValue)
            }
        }
    }
    // MARK: - Back Button Action
    ///Create action for navigate to previous Screen
    /// - Parameter sender: UIButton
    /// /// return : nil
    @IBAction func backButtonAction(_ sender: UIButton) {
        self.navigationController?.popViewController(animated: true)
    }
    // MARK: - Previous Button Action
    ///Create action for see the previous QR-Codes
    /// - Parameter sender: UIButton
    /// /// return : nil
    @IBAction func previousButtonAction(_ sender: Any) {
        if currentPage > 1{
            currentPage -= 1
        }
            lblCount.text = ("\(currentPage) of \(ticketModel?.data?.count ?? 0)")
            scrollToPreviousCell()
    }
    // MARK: - Next Button Action
    ///Create action for see the next QR-Codes
    /// - Parameter sender: UIButton
    /// /// return : nil
    @IBAction func nextButtonAction(_ sender: Any) {
        if currentPage == ticketModel?.data?.count ?? 0 {
        }else{
            currentPage += 1
            lblCount.text = ("\(currentPage) of \(ticketModel?.data?.count ?? 0)")
            print(currentPage)
            scrollToNextCell()
            
        }
    }
    // MARK: - Create function for scroll QR on next button
    func scrollToNextCell() {
        let cellSize = CGSize(width: self.view.frame.width, height: self.view.frame.height)
        let contentOffset = collectionView.contentOffset
        collectionView.scrollRectToVisible(CGRectMake(contentOffset.x + 10 + cellSize.width, contentOffset.y, cellSize.width, cellSize.height), animated: true)
       // collectionView.reloadData()
        }
    // MARK: - Create function for scroll QR on previous button
    func scrollToPreviousCell() {
        let cellSize = CGSize(width: self.view.frame.width, height: self.view.frame.height)
        let contentOffset = collectionView.contentOffset
        collectionView.scrollRectToVisible(CGRectMake(contentOffset.x - 10 - cellSize.width, contentOffset.y, cellSize.width, cellSize.height), animated: true)
       // collectionView.reloadData()
        }
    
    // MARK: - Create function for generate Qr Code from string
    func generateQRCode(from string: String) -> UIImage? {
        let data = string.data(using: String.Encoding.ascii)

        if let filter = CIFilter(name: "CIQRCodeGenerator") {
            filter.setValue(data, forKey: "inputMessage")
            let transform = CGAffineTransform(scaleX: 3, y: 3)

            if let output = filter.outputImage?.transformed(by: transform) {
                return UIImage(ciImage: output)
            }
        }
        return nil
    }
}
// MARK: - Create extension for colleectionView Delegate
extension TicketDetailsViewController: UICollectionViewDelegate,UICollectionViewDataSource{
    func collectionView(_ collectionView: UICollectionView, numberOfItemsInSection section: Int) -> Int {
        return ticketModel?.data?.count ?? 0 
    }
    func collectionView(_ collectionView: UICollectionView, cellForItemAt indexPath: IndexPath) -> UICollectionViewCell {
        let cell = collectionView.dequeueReusableCell(withReuseIdentifier: TicketCollectionViewCell.identifier, for: indexPath) as! TicketCollectionViewCell
        let uniqueCode = ticketModel?.data?[indexPath.row].ticketNo ?? DefaultValue.emptyString.rawValue
        debugPrint("\(uniqueCode) indexpath \(indexPath.row)")
        
        //cell.imageQRCode.image = UIImage()
          let image = generateQRCode(from: uniqueCode)
        cell.imageQRCode.image = image

        return cell
    }
    func scrollViewDidEndDecelerating(_ scrollView: UIScrollView) {
        let width = scrollView.frame.width
        currentPage = Int(scrollView.contentOffset.x / width)
    }
}
// MARK: - Create extension for collectionview Delegate
/// create function for fixed the size for collection view image
extension TicketDetailsViewController: UICollectionViewDelegateFlowLayout {
    // 1
    func collectionView(_ collectionView: UICollectionView,layout collectionViewLayout: UICollectionViewLayout,sizeForItemAt indexPath: IndexPath
    ) -> CGSize {
        // 2
        let width = collectionView.frame.width
        return CGSize(width: width, height: width)
    }
}
